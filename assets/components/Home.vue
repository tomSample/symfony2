<template>
    <div class="portfolio">
        <h1>Mon portfolio étudiant</h1>
        <div v-if="apiData" class="content">
            <h2>{{ apiData.catcher }}</h2>
            <p>{{ apiData.description }}</p>
            <img :src="getFullImageUrl(apiData.profile_picture.url)" :alt="apiData.profile_picture.alternativeText || 'Profile Picture'" class="profile-picture" />
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
            apiData: null,
        };
    },
    methods: {
        getFullImageUrl(relativeUrl) {
            return `http://localhost:1337${relativeUrl}`;
        }
    },
    mounted() {
    fetch('/api/home')
      .then(response => response.json())
      .then(data => {
        this.apiData = data.data; // Accéder directement à l'objet data
      });
  },
};
</script>

<style scoped>
.portfolio {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
}

.content {
    text-align: center;
}

.profile-picture {
    max-width: 200px;
    border-radius: 50%;
    margin: 20px 0;
}

.loading {
    text-align: center;
    font-size: 1.2em;
    color: #666;
}
</style>


