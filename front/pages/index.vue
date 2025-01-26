<template>
    <div>
        <UInput v-model="search" />

        <UTable :rows="recalls" :columns="columns" :loading="isLoading">
            <template #action-data="{ row }">
                <UButton @click="openModal(row)" icon="i-heroicons-eye" />
            </template>
            <template #tags-data="{ row }">
                <div class="flex flex-row">
                    <div
                        v-for="(tag, index) in row.tags"
                        :key="index"
                        class="mr-2"
                    >
                        <UBadge>{{ tag.value }}</UBadge>
                    </div>
                </div>
            </template>
        </UTable>

        <UModal v-model="isModalOpen">
            <UCard
                :ui="{
                    ring: '',
                    divide: 'divide-y divide-gray-100 dark:divide-gray-800',
                }"
            >
                <template #header>
                    <h2>Details for {{ selectedRow.productName }}</h2>
                </template>

                <p><strong>Numéro:</strong> {{ selectedRow.id }}</p>

                <p>
                    <strong>Name product:</strong>
                    {{ selectedRow.productName }}
                </p>

                <p>
                    <strong>importId:</strong>
                    {{ selectedRow.importId }}
                </p>

                <p>
                    <strong>Image Uri:</strong>
                    <UTooltip :text="selectedRow.imageUri">
                        {{ truncateUrl(selectedRow.imageUri) }}
                    </UTooltip>
                </p>

                <p>
                    <strong>Uri:</strong>
                    <UTooltip :text="selectedRow.uri">
                        {{ truncateUrl(selectedRow.uri) }}
                    </UTooltip>
                </p>

                <p>
                    <strong>URL:</strong>
                    <UTooltip :text="selectedRow.url">
                        {{ truncateUrl(selectedRow.url) }}
                    </UTooltip>
                </p>

                <p><strong>Tags:</strong></p>
                <ul>
                    <UBadge
                        v-for="(tag, index) in selectedRow.tags"
                        :key="index"
                        class="ml-2"
                    >
                        {{ tag.value }}
                    </UBadge>
                </ul>

                <p><strong>Manufacturer Country:</strong></p>
                <ul>
                    <UBadge
                        v-for="(
                            country, index
                        ) in selectedRow.manufacturerCountry"
                        :key="index"
                        class="ml-2"
                    >
                        {{ country.code }} - {{ country.name }}
                    </UBadge>
                </ul>

                <template #footer>
                    <UButton @click="closeModal">Close</UButton>
                </template>
            </UCard>
        </UModal>
    </div>
</template>

<script setup>
import { fecthData } from "@/utils/useFetch";
import { onMounted } from "vue";

const isModalOpen = ref(false);
const selectedRow = ref({});
const isLoading = ref(false);

const search = ref("");

const openModal = (row) => {
    selectedRow.value = row;
    isModalOpen.value = true;
    console.log(row);
};

const closeModal = () => {
    isModalOpen.value = false;
};

const apiURL = "http://localhost/recall";

const recalls = ref([]);

const columns = [
    {
        key: "action",
        label: "Action",
    },
    {
        key: "id",
        label: "Numéro",
    },
    {
        key: "productName",
        label: "Name product",
    },
    {
        key: "tags",
        label: "Tags",
    },
];

const fetchRecalls = async (query) => {
    isLoading.value = true;

    try {
        recalls.value = await fecthData(`${apiURL}?name=${query}`);
    } catch (error) {
        console.error(error);
        isLoading.value = false;
    }

    isLoading.value = false;
};

const truncateUrl = (url) => {
    const maxLength = 30;
    if (url.length > maxLength) {
        return url.substring(0, maxLength) + "...";
    }
    return url;
};

let debounceTimeout;
const debounceFetchRecalls = (query) => {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
        fetchRecalls(query);
    }, 300);
};

watch(search, (newSearch) => {
    debounceFetchRecalls(newSearch);
});

onMounted(() => {
    fetchRecalls("");
});
</script>
