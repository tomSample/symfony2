<template>
    <div class="project-details">
        <div v-if="loading" class="loading">
            Loading...
        </div>
        <div v-else-if="error" class="error">
            Error loading project details.
        </div>
        <div v-else>
            <div v-if="project.media" class="project-media">
                <h2>Media</h2>
                <img :src="getFullImageUrl(project.media.url)" :alt="project.media.alternativeText || 'Project Image'" class="project-image" />
            </div>
            <h1 class="project-title">{{ project.name }}</h1>
            <p class="project-description">{{ project.description }}</p>
            <p class="project-date"><strong>Date:</strong> {{ project.date }}</p>
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
.project-details {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
}

.loading, .error {
    text-align: center;
    font-size: 1.2em;
    color: #ff0000;
}

.project-title {
    font-size: 2em;
    margin-bottom: 10px;
    color: #333;
}

.project-description {
    font-size: 1.2em;
    margin-bottom: 20px;
    color: #666;
}

.project-date {
    font-size: 1em;
    margin-bottom: 20px;
    color: #999;
}

.project-media {
    margin-top: 20px;
}

.project-image {
    width: 800px;
    height: 500px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>