export const accordionJS = () => {
	const accordion = document.querySelector('.accordion');
	if (accordion) {
		const accordionPanel = document.querySelectorAll('.accordion__panel');
		console.log(accordionPanel);
		const accordionBtn = document.querySelectorAll('.accordion__panel__button');
		const accordionContent = document.querySelectorAll('.accordion__panel__content');
		accordionBtn.forEach((item, i) => {
			item.addEventListener('click', () => {

				accordionBtn.forEach((item, index) => {
					item.setAttribute('aria-expanded', 'false');
					$(accordionPanel[index]).removeClass('active');
					$(accordionContent[index]).not(accordionContent[i]).slideUp(200);
				});

				item.setAttribute('aria-expanded', 'true');
				$(accordionPanel[i]).toggleClass('active');
				$(accordionContent[i]).slideToggle(200);
			});
		});
	}
};
