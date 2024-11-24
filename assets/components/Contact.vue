<template>
    <div class="contact-form">
        <h1>Contact</h1>
        <form @submit.prevent="submitForm">
            <div>
                <label for="your_name">Name:</label>
                <input type="text" v-model="form.your_name" id="your_name" required />
            </div>
            <div>
                <label for="your_email">Email:</label>
                <input type="email" v-model="form.your_email" id="your_email" required />
            </div>
            <div>
                <label for="your_message">Message:</label>
                <textarea v-model="form.your_message" id="your_message" required></textarea>
            </div>
            <button type="submit">Send</button>
        </form>
        <div v-if="response">
            <h2>Response</h2>
            <pre>{{ response }}</pre>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                your_name: '',
                your_email: '',
                your_message: '',
            },
            response: null,
        };
    },
    methods: {
        async submitForm() {
            try {
                const response = await fetch('http://localhost:1337/api/contacts', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ data: this.form }),
                });
                const result = await response.json();
                this.response = result;
                if (response.ok) {
                    alert('Message sent successfully!');
                    this.form = {
                        your_name: '',
                        your_email: '',
                        your_message: '',
                    };
                } else {
                    alert('Failed to send message.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while sending the message.');
            }
        },
    },
};
</script>

<style scoped>
.contact-form {
    max-width: 600px;
    margin: 0 auto;
    padding: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.contact-form div {
    margin-bottom: 1rem;
}
.contact-form label {
    display: block;
    margin-bottom: 0.5rem;
}
.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.contact-form button {
    padding: 0.5rem 1rem;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.contact-form button:hover {
    background-color: #0056b3;
}
</style>