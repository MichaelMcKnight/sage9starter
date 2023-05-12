import Splide from '@splidejs/splide';
// import { AutoScroll } from '@splidejs/splide-extension-auto-scroll';

export const basicSplide = () => {
	const element = document.getElementById('basic-splide');
	if (element) {
		new Splide(element, {
			gap: '1rem',
			pagination: false,
			perMove: 1,
			perPage: 1,
			drag: true,
			type: 'loop',
		}).mount();
	}
};
