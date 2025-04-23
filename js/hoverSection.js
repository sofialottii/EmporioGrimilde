document.querySelectorAll('.section-example').forEach((section) => {

    section.addEventListener('mouseenter', () => {
        section.style.transform = 'scale(1.01)';
        section.style.backgroundColor = '#f4f4f4';
        section.style.cursor = 'pointer';
    });

    section.addEventListener('mouseleave', () => {
        section.style.transform = 'scale(1)';
        section.style.backgroundColor = '#fff';
    });
});
