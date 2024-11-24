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
        <div v-if="commentsData" class="comments">
            <h2>Commentaires</h2>
            <div class="comments-carousel">
                <ul>
                    <li v-for="comment in commentsData" :key="comment.id">
                        <div v-if="comment.media" class="comment-media-container">
                            <img :src="getFullImageUrl(comment.media.url)" :alt="comment.media.alternativeText || 'Media'" class="comment-media" />
                        </div>
                        <p>{{ comment.text }}</p>
                        <p>{{ comment.date }}</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            apiData: null,
            commentsData: null,
        };
    },
    methods: {
        getFullImageUrl(relativeUrl) {
            return `http://localhost:1337${relativeUrl}`;
        },
        fetchHomeData() {
            fetch('/api/home')
                .then(response => response.json())
                .then(data => {
                    this.apiData = data.data; // Accéder directement à l'objet data
                });
        },
        fetchCommentsData() {
            fetch('/api/comments')
                .then(response => response.json())
                .then(data => {
                    this.commentsData = data.data; // Accéder directement à l'objet data
                });
        }
    },
    mounted() {
        this.fetchHomeData();
        this.fetchCommentsData();
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

.comments {
    margin-top: 20px;
}

.comments h2 {
    text-align: center;
    color: #333;
}

.comments-carousel {
    overflow: hidden;
    white-space: nowrap;
}

.comments ul {
    display: flex;
    animation: scroll 20s linear infinite;
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.comments li {
    background-color: #f1f1f1;
    margin: 5px;
    padding: 10px;
    border-radius: 5px;
    display: inline-block;
    flex: 0 0 auto;
    width: 200px;
    text-align: center;
}

.comment-media-container {
    display: flex;
    justify-content: center;
    margin-top: 10px;
}

.comment-media {
    max-width: 100px;
    margin: 0 5px;
}

@keyframes scroll {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}
</style>