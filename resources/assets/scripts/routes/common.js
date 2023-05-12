import { accordionJS } from '../components/accordion';
import initializedMenu from '../lib/mmenu';
import {basicSplide} from '../lib/splide';
import AOS from 'aos';
import '@fancyapps/fancybox/dist/jquery.fancybox.min.js';

export default {
	init() {
		// JavaScript to be fired on all pages

		// Animate on Scroll Library https://michalsnik.github.io/aos/
		AOS.init();

		// Component
		// Accordion
		accordionJS();

		// Lib

		// Mobile Menu https://mmenujs.com/
		initializedMenu();
		// Splide https://splidejs.com/
		basicSplide();

	},
	finalize() {
		// JavaScript to be fired on all pages, after page specific JS is fired
	},
};
