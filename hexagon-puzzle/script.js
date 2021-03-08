const timer = {
  startTime: new Date(), 
  endTime: null,
  get time(){
    return (this.endTime.getTime() - this.startTime.getTime()) / 1000;
  }
}
let completed = 0;

const wrapper = document.querySelector('.wrapper');
const container = document.querySelector('.container');
const messageDiv = document.querySelector('[data-message]');
const startDiv = document.querySelector('[data-start]');
const taskDiv = document.querySelector('[data-task]');

const grid = document.querySelector('[data-grid]');
const targetCells = document.querySelectorAll('[data-target-cell]');
const piecesContainer = document.querySelector('[data-pieces-container]');
const puzzlePieces = document.querySelectorAll('[data-piece]');

const restartButton = document.querySelector('[data-restart]');
restartButton.addEventListener('click', () => location.reload());

const finishButton = document.querySelector('[data-finish]');
finishButton.addEventListener('click', completedGame);

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
  piece.addEventListener('dragend', e => e.target.classList.remove('dragging'));
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

function completedGame(){
  if(piecesContainer.childElementCount > 0) {
    alert('Ahhoz, hogy befejezd minden hatszöget fel kell használj!');
    return;
  }

  wrapper.classList.add('winner');
  taskDiv.classList.add('hidden');
  messageDiv.classList.remove('hidden');
  timer.endTime = new Date();

  saveData();
}

function saveData(){
  completed = 1;
  window.scrollTo(0, 0);
  html2canvas(grid).then(canvas => {
    const image = canvas.toDataURL("image/jpg", 0.9);
    $.ajax({
      type: "POST",
      url: './save.php',
      data: {
        image: image, 
        time: timer.time,
        completed: completed
      },
      success: (result) => {
        console.log(result);
      },
    });
  })
}

$(window).on('beforeunload', () => {
  if(!completed){
    timer.endTime = new Date();
    let data = new FormData();
    data.append('time', timer.time);
    data.append('completed', completed);
  
    navigator.sendBeacon('./save.php', data);
  }
});

window.addEventListener("resize", () => {
  taskDiv.style.width = `${container.offsetWidth}px`;
})


setup();