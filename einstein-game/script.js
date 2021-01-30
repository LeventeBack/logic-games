const targetCells = document.querySelectorAll('[data-target-cell]');

const imgContainer = document.querySelector('[data-img-container]');
const images = document.querySelectorAll('[data-img]');

images.forEach(test => {
  test.setAttribute('draggable', true);
  test.addEventListener('dragstart', e => e.target.classList.add('dragging'));
  test.addEventListener('dragend', e => e.target.classList.remove('dragging'));
})
targetCells.forEach(cell => {
  cell.addEventListener('dragover', e => {
    e.preventDefault();
    const selection = e.target;

    if(!selection.classList.contains('house__cell')) return;
    if(selection.innerHTML != "") return;

    const draggedImg = document.querySelector('.dragging');
    selection.appendChild(draggedImg);
  })
})