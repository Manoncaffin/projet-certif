setTimeout(function() {
    const redirectUrl = document.querySelector('#redirect-container').dataset.redirectUrl;
    window.location.href = redirectUrl;
}, 5000);