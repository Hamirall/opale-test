<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Recall;
use App\Entity\Language;
use App\Entity\Country;
use App\Entity\Tag;

class ImportRecalls
{
    protected $httpClient;
    protected $entityManager;

    public function __construct(
        HttpClientInterface $httpClient,
        EntityManagerInterface $entityManager
    ) {
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
    }

    public function callApi(): array
    {
        try {
            $response = $this->httpClient->request(
                "GET",
                $_ENV["RECALL_API_SERVICE"]
            );
        } catch (\Exception $e) {
            throw new \Exception("Failed to fetch data from the API");
        }

        $data = $response->toArray();

        return $data;
    }

    /**
     * @param array $data
     * @return void
     */
    public function importRecalls(array $data): void
    {
        $languagesCache = [];
        $countriesCache = [];
        $tagsCache = [];

        foreach ($data as $recallData) {
            $newRecall = new Recall();

            $newRecall->setUri($recallData["uri"]);
            $newRecall->setDate(new \DateTime($recallData["date"]));
            $newRecall->setExtUrl($recallData["extUrl"]);
            $newRecall->setImportId($recallData["id"]);
            $newRecall->setImageUri($recallData["imageUri"]);
            $newRecall->setUrl($recallData["url"]);
            $newRecall->setProductName($recallData["product.name"]);

            // Handle Language
            $languageName = $recallData["language"];
            if (!isset($languagesCache[$languageName])) {
                $language = $this->entityManager
                    ->getRepository(Language::class)
                    ->findOneBy(["name" => $languageName]);
                if (!$language) {
                    $language = new Language();
                    $language->setName($languageName);
                    $language->setCode($recallData["languageId"]);
                    $this->entityManager->persist($language);
                }
                $languagesCache[$languageName] = $language;
            }
            $newRecall->setLanguage($languagesCache[$languageName]);

            // Handle Country
            $countryName = $recallData["countryName"];
            if (!isset($countriesCache[$countryName])) {
                $country = $this->entityManager
                    ->getRepository(Country::class)
                    ->findOneBy(["name" => $countryName]);
                if (!$country) {
                    $country = new Country();
                    $country->setName($countryName);
                    $country->setCode($recallData["countryId"]);
                    $this->entityManager->persist($country);
                }
                $countriesCache[$countryName] = $country;
            }
            $newRecall->setCountry($countriesCache[$countryName]);

            // Handle Manufacturer Countries
            foreach (
                $recallData["manufacturer.country"]
                as $manufacturerCountryData
            ) {
                $manufacturerCountryName = $manufacturerCountryData["name"];
                if (!isset($countriesCache[$manufacturerCountryName])) {
                    $manufacturerCountry = $this->entityManager
                        ->getRepository(Country::class)
                        ->findOneBy(["name" => $manufacturerCountryName]);
                    if (!$manufacturerCountry) {
                        $manufacturerCountry = new Country();
                        $manufacturerCountry->setName($manufacturerCountryName);
                        $manufacturerCountry->setCode(
                            $manufacturerCountryData["id"]
                        );
                        $this->entityManager->persist($manufacturerCountry);
                    }
                    $countriesCache[
                        $manufacturerCountryName
                    ] = $manufacturerCountry;
                }
                $newRecall->addManufacturerCountry(
                    $countriesCache[$manufacturerCountryName]
                );
            }

            // Handle Tags
            foreach ($recallData["tags"] as $tagData) {
                $tagValue = $tagData["value"];
                if (!isset($tagsCache[$tagValue])) {
                    $tag = $this->entityManager
                        ->getRepository(Tag::class)
                        ->findOneBy(["value" => $tagValue]);
                    if (!$tag) {
                        $tag = new Tag();
                        $tag->setName($tagData["name"]);
                        $tag->setValue($tagValue);
                        $this->entityManager->persist($tag);
                    }
                    $tagsCache[$tagValue] = $tag;
                }
                $newRecall->addTag($tagsCache[$tagValue]);
            }

            $this->entityManager->persist($newRecall);
        }

        $this->entityManager->flush();
    }
}
