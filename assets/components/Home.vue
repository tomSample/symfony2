<template>
    <div class="portfolio">
        <h1>Mon portfolio étudiant</h1>
        <div v-if="apiData" class="content">
            <div class="profile-section">
                <img :src="getFullImageUrl(apiData.profile_picture.url)" :alt="apiData.profile_picture.alternativeText || 'Profile Picture'" class="profile-picture" />
                <div class="profile-info">
                    <h2>{{ apiData.catcher }}</h2>
                    <p>{{ apiData.description }}</p>
                </div>
            </div>
        </div>
        <div v-else class="loading">
            Loading...
        </div>
        <div v-if="commentsData" class="comments">
            <h2>Commentaires</h2>
            <div class="comments-carousel" @mouseover="pauseScroll" @mouseleave="resumeScroll">
                <div class="carousel-fade-left"></div>
                <ul ref="commentsList">
                    <li v-for="comment in commentsData" :key="comment.id" class="comment-item">
                        <div v-if="comment.media" class="comment-media-container">
                            <img :src="getFullImageUrl(comment.media.url)" :alt="comment.media.alternativeText || 'Media'" class="comment-media" />
                        </div>
                        <p class="comment-text">{{ comment.text }}</p>
                        <p class="comment-date">{{ comment.date }}</p>
                    </li>
                </ul>
                <div class="carousel-fade-right"></div>
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
      scrollInterval: null,
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
          this.$nextTick(() => {
            this.startScroll();
          });
        });
    },
    startScroll() {
      const commentsList = this.$refs.commentsList;
      if (commentsList) {
        // Clone the comments and append them to the end of the list
        const clonedComments = commentsList.innerHTML;
        commentsList.innerHTML += clonedComments;

        this.scrollInterval = setInterval(() => {
          commentsList.scrollBy({ left: 5, behavior: 'smooth' });
          if (commentsList.scrollLeft >= commentsList.scrollWidth / 2) {
            commentsList.scrollLeft = 0;
          }
        }, 50);
      }
    },
    pauseScroll() {
      clearInterval(this.scrollInterval);
    },
    resumeScroll() {
      this.startScroll();
    }
  },
  mounted() {
    this.fetchHomeData();
    this.fetchCommentsData();
  },
  beforeDestroy() {
    clearInterval(this.scrollInterval);
  },
};
</script>

<style scoped>
.portfolio {
    font-family: Arial, sans-serif;
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

.content {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.profile-section {
    display: flex;
    align-items: center;
    margin-bottom: 40px;
}

.profile-picture {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.profile-info {
    max-width: 600px;
}

.profile-info h2 {
    font-size: 2em;
    margin-bottom: 10px;
    color: #333;
}

.profile-info p {
    font-size: 1.2em;
    color: #666;
}

.loading {
    text-align: center;
    font-size: 1.5em;
    color: #999;
}

.comments {
    margin-top: 40px;
}

.comments h2 {
    font-size: 2em;
    margin-bottom: 20px;
    text-align: center;
    color: #333;
}

.comments-carousel {
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.carousel-fade-left, .carousel-fade-right {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 50px;
    z-index: 1;
    pointer-events: none;
}

.carousel-fade-left {
    left: 0;
    background: linear-gradient(to right, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));
}

.carousel-fade-right {
    right: 0;
    background: linear-gradient(to left, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));
}

.comments ul {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    overflow: hidden;
}

.comment-item {
    flex: 0 0 auto;
    width: 150px;
    margin-right: 20px;
    background-color: #f9f9f9;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: opacity 0.5s ease-in-out;
}

.comment-media-container {
    text-align: center;
    margin-bottom: 10px;
}

.comment-media {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
}

.comment-text {
    font-size: 0.9em;
    margin-bottom: 5px;
    color: #666;
}

.comment-date {
    font-size: 0.7em;
    color: #999;
    text-align: right;
}
</style>