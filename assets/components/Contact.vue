<template>
    <div class="contact">
        <h1>Contactez-nous</h1>
        <form @submit.prevent="submitForm" class="contact-form">
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" id="name" v-model="form.name" required />
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" v-model="form.email" required />
            </div>
            <div class="form-group">
                <label for="subject">Sujet</label>
                <input type="text" id="subject" v-model="form.subject" required />
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" v-model="form.message" required></textarea>
            </div>
            <button type="submit" class="submit-button">Envoyer</button>
        </form>
    </div>
</template>

<script>
import emailjs from 'emailjs-com';

export default {
    data() {
        return {
            form: {
                name: '',
                email: '',
                subject: '',
                message: ''
            }
        };
    },
    methods: {
        submitForm() {
            const serviceID = 'service_hw97a5k';
            const templateID = 'template_v5pezdl';
            const userID = 'sjE15GMtyAGd_ekAh';

            const templateParams = {
                name: this.form.name,
                email: this.form.email,
                subject: this.form.subject,
                message: this.form.message
            };

            emailjs.send(serviceID, templateID, templateParams, userID)
                .then(response => {
                    console.log('Success:', response.status, response.text);
                    alert('Message envoyé avec succès!');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors de l\'envoi du message.');
                });
        }
    }
};
</script>

<style scoped>
.contact {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.contact h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.contact-form {
    display: flex;
    flex-direction: column;
}

.form-group {
    margin-bottom: 1rem;
}

.contact-form label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: bold;
    color: #333;
}

.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.submit-button {
    padding: 0.75rem;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: #fff;
    font-size: 1rem;
    cursor: pointer;
}

.submit-button:hover {
    background-color: #0056b3;
}
</style>