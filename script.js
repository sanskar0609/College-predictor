function generateCaptcha() {
    const captcha = Math.random().toString(36).substr(2, 5).toUpperCase();
    document.getElementById('captcha-text').innerText = captcha;
    document.getElementById('captcha-hidden').value = captcha;
}

// Generate a captcha on page load
window.onload = generateCaptcha;
