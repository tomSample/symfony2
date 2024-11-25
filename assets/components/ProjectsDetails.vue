<template>
    <div>
        <div v-if="loading">
            Loading...
        </div>
        <div v-else-if="error">
            Error loading project details.
        </div>
        <div v-else>
            <h1>{{ project.name }}</h1>
            <p>{{ project.description }}</p>
            <p><strong>Date:</strong> {{ project.date }}</p>
            <div v-if="project.media">
                <h2>Media</h2>
                <img :src="getFullImageUrl(project.media.url)" :alt="project.media.alternativeText || 'Project Image'" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            project: null,
            loading: true,
            error: false
        };
    },
    created() {
        const documentId = window.location.pathname.split('/').pop().replace('.html', '');
        this.fetchProjectDetails(documentId);
    },
    methods: {
        getFullImageUrl(relativeUrl) {
            return `http://localhost:1337${relativeUrl}`;
        },
        async fetchProjectDetails(documentId) {
            try {
                console.log(`Fetching project details for documentId: ${documentId}`);
                const response = await fetch(`/api/projects/${documentId}?populate=*`);
                console.log('Response status:', response.status);
                if (!response.ok) {
                    console.error('Response not ok:', response);
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                console.log('Fetched data:', data);
                this.project = data.data; // Assuming the API returns the project data directly
            } catch (error) {
                console.error('Error fetching project details:', error);
                this.error = true;
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>

<style scoped>
/* Add your styles here */
</style>