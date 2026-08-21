document.addEventListener('DOMContentLoaded', () => {
    const addRowBtn = document.querySelector('.quick-order-form .btn-small');
    if (addRowBtn) {
        addRowBtn.addEventListener('click', () => {
            const form = document.querySelector('.quick-order-form');
            const newRow = document.createElement('div');
            newRow.className = 'form-row';
            newRow.style.marginTop = '10px';
            newRow.innerHTML = `
                <input type="text" name="isbn[]" placeholder="ISBN (z.B. 978-3-16-148410-0)">
                <input type="number" name="quantity[]" value="1" min="1" placeholder="Menge">
                <button type="button" class="btn btn-small btn-danger" onclick="this.parentElement.remove()">✕</button>
            `;
            form.insertBefore(newRow, form.querySelector('button[type="submit"]'));
        });
    }
});