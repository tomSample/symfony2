/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import home from './components/Home.vue';
import projects from './components/Projects.vue';
import about from './components/About.vue';
import contact from './components/Contact.vue';
import { createApp } from 'vue';

createApp(home).mount('#home');
createApp(projects).mount('#projects');
createApp(about).mount('#about');
createApp(contact).mount('#contact');