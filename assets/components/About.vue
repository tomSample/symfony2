<template>
    <div class="about">
        <h1>À propos de moi</h1>
        <div v-if="aboutData" class="about-content">
            <img :src="getFullImageUrl(aboutData.profile_picture.url)" alt="Profile Picture" class="profile-image" />
            <div class="about-text">
                <p>{{ aboutData.description }}</p>
                <div class="about-links">
                    <button v-for="link in aboutData.about_url" :key="link.id" @click="openLink(link.url)" class="cta-button">
                        {{ link.link_name }}
                    </button>
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
        },
        openLink(url) {
            window.open(url, '_blank');
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

.cta-button {
    display: inline-block;
    margin: 10px 5px;
    padding: 10px 20px;
    font-size: 1em;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
}

.cta-button:hover {
    background-color: #0056b3;
}

.loading {
    font-size: 1.2em;
    color: #666;
}
</style>