const timer = {
  startTime: new Date(), 
  endTime: null,
  get time(){
    return (this.endTime.getTime() - this.startTime.getTime()) / 1000;
  }
}

const wrapper = document.querySelector('.wrapper');
const container = document.querySelector('.container');
const messageDiv = document.querySelector('[data-message]');
const startDiv = document.querySelector('[data-start]');
const taskDiv = document.querySelector('[data-task]');

const grid = document.querySelector('[data-grid]');
const targetCells = document.querySelectorAll('[data-target-cell]');
const piecesContainer = document.querySelector('[data-pieces-container]');
const puzzlePieces = document.querySelectorAll('[data-piece]');

function setup(){
  $('.pieces-container').html($("[data-piece]").sort(() => Math.random()-0.5));
  taskDiv.style.width = `${container.offsetWidth}px`;
}

targetCells.forEach(targetCell => {
  targetCell.addEventListener('dragover', e => {
    e.preventDefault();
    const selection = e.target;

    if(!selection.classList.contains('target-cell')) return;

    const draggedElement = document.querySelector('.dragging');
    draggedElement.classList.add('hexagon');
    selection.appendChild(draggedElement);
  });
})

puzzlePieces.forEach((piece, index) => {
  piece.addEventListener('dragstart', e => e.target.classList.add('dragging'));
  piece.addEventListener('dragend', e => {
    e.target.classList.remove('dragging')
    if(piecesContainer.childElementCount === 0 && hasWon())
      winningGame();
  });
  piece.style.backgroundImage = `url('./pics/${index + 1}.png')`;
  piece.dataset.id = index + 1;
  piece.setAttribute('draggable', true);
})

piecesContainer.addEventListener('dragover', e => {
  e.preventDefault();  
  const selection = e.target;

  if(!selection.classList.contains('pieces-container')) return;

  const draggedElement = document.querySelector('.dragging');
  draggedElement.classList.remove('hexagon');
  selection.appendChild(draggedElement);
})

function hasWon(){
  for(let i = 0; i < targetCells.length; i++){
    const targetCell = targetCells[i];
    const puzzlePiece = targetCell.querySelector('[data-piece]');
    if(targetCell.dataset.id !== puzzlePiece.dataset.id)
      return false;
  }
  return true;
}

function winningGame(){
  wrapper.classList.add('winner');
  taskDiv.classList.add('hidden');
  messageDiv.classList.remove('hidden');
  timer.endTime = new Date();

  saveData();
}

function saveData(){
  $.ajax({
    type: "POST",
    url: './save.php',
    data: {time: timer.time},
    success: function(result) {
      console.log(result);
    },
  });
}

window.addEventListener("resize", () => {
  taskDiv.style.width = `${container.offsetWidth}px`;
})

setup();