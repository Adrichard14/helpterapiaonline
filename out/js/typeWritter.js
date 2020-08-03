function typeWritter(e) {
    const textArray = e.innerHTML.split('');
    e.innerHTML = '';
    textArray.forEach((word, index) => {
        setTimeout(() => e.innerHTML += word, 200 * index);
    })
}