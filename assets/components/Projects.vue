<template>
    <div class="projects">
        <h1>Projets</h1>
        <div v-if="projectsData" class="projects-list">
            <a v-for="project in projectsData" :key="project.documentId" :href="`/projects/${project.documentId}.html`" class="project-card">
                <img :src="getFullImageUrl(project.media.url)" :alt="project.media.alternativeText || 'Project Image'" class="project-image" />
                <h2>{{ project.name }}</h2>
                <p>{{ project.description }}</p>
            </a>
        </div>
        <div v-else class="loading">
            Loading...
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            projectsData: null,
        };
    },
    methods: {
        getFullImageUrl(relativeUrl) {
            return `http://localhost:1337${relativeUrl}`;
        },
        fetchProjectsData() {
            fetch('/api/projects')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    this.projectsData = data.data;
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        }
    },
    created() {
        this.fetchProjectsData();
    }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

.projects {
    font-family: 'Roboto', sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
    font-size: 2.5em;
    margin-bottom: 20px;
}

.projects-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
}

.project-card {
    background-color: #f9f9f9;
    margin: 10px;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
    transition: transform 0.3s ease;
}

.project-card:hover {
    transform: translateY(-10px);
    background-color: #cce3fc;
}

.project-image {
    width: 150px; /* Taille fixe pour la largeur */
    height: 150px; /* Taille fixe pour la hauteur */
    object-fit: cover; /* Pour couvrir le cadre sans déformer l'image */
    border-radius: 8px;
    margin-bottom: 15px;
}

.loading {
    text-align: center;
    font-size: 1.2em;
    color: #666;
}
</style>