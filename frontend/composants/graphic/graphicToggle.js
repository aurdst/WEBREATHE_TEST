document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.card').forEach(card => {

        card.addEventListener('click', function() {
            const graphicsContainer = this.querySelector('.graphics-container');

            if (graphicsContainer.style.display === 'none' || graphicsContainer.style.display === '') {
                graphicsContainer.style.display = 'block';
            } else {
                graphicsContainer.style.display = 'none';
            }
        })
    })
})