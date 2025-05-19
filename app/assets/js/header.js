

document.addEventListener('DOMContentLoaded', function() {

    const aboutUsLink = document.getElementById('aboutUsLink');
    if (aboutUsLink) {
        aboutUsLink.addEventListener('click', function(e) {
            e.preventDefault();
            const aboutusSection = document.querySelector('.aboutus');
            if (aboutusSection) {
                aboutusSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }

    const contactLink = document.getElementById('contactLink');
    if (contactLink) {
        contactLink.addEventListener('click', function(e) {
            e.preventDefault();
            const contactModal = document.querySelector('#contactModal');
            if (contactModal) { 
                contactModal.style.display = 'block';
            }
        });
    } 

    const closeBtn = document.querySelector('.close');
    if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const contactModal = document.querySelector('#contactModal');
            if (contactModal) {
                contactModal.style.display = 'none';
            }
        });
    }

    const contactLink1 = document.getElementById('contactLink1');
    if (contactLink1) {
        contactLink1.addEventListener('click', function(e) {
            e.preventDefault();
            const contactModal = document.querySelector('#contactModal');
            if (contactModal) { 
                contactModal.style.display = 'block';
            }
        });
    } 

    const closeBtn1 = document.querySelector('.close');
    if (closeBtn1) {
        closeBtn1.addEventListener('click', function(e) {
            e.preventDefault();
            const contactModal = document.querySelector('#contactModal');
            if (contactModal) {
                contactModal.style.display = 'none';
            }
        });
    }

    
    
});



    