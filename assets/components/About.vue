<template>
    <div class="about">
        <h1>À propos de moi</h1>
        <div v-if="aboutData" class="about-content">
            <img :src="getFullImageUrl(aboutData.profile_picture.url)" alt="Profile Picture" class="profile-image" />
            <div class="about-text">
                <p>{{ aboutData.description }}</p>
                <div class="about-links">
                    <a v-for="link in aboutData.about_url" :key="link.id" :href="link.url" target="_blank" class="about-link">
                        {{ link.url }}
                    </a>
                </div>
            </div>
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
            aboutData: null,
        };
    },
    methods: {
        getFullImageUrl(relativeUrl) {
            return `http://localhost:1337${relativeUrl}`;
        },
        fetchAboutData() {
            fetch('/api/about')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Fetched data:', data); // Ajoutez cette ligne pour déboguer
                    this.aboutData = data.data;
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        }
    },
    mounted() {
        this.fetchAboutData();
    },
};
</script>

<style scoped>
.about {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.about-content {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.profile-image {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
}

.about-text {
    text-align: center;
}

.about-text p {
    font-size: 1.2em;
    color: #666;
}

.about-links {
    margin-top: 20px;
}

.about-link {
    display: block;
    color: #007bff;
    text-decoration: none;
    margin-bottom: 10px;
}

.about-link:hover {
    text-decoration: underline;
}

.loading {
    font-size: 1.2em;
    color: #666;
}
</style>