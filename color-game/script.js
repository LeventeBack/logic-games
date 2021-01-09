
const WHITE = "rgb(255, 255, 255)";
const COLORS = [
  "rgb(245,242,66)",
  "rgb(19,235,91)",
  "rgb(92,158,237)",
  "rgb(230,16,16)",
  "rgb(201,92,237)",
  WHITE
];

const grid = document.querySelector('[data-grid]');
const gridCells = document.querySelectorAll('[data-grid-cell]')
const colors = document.querySelectorAll('[data-color]');

const restartButton = document.querySelector('[data-restart]');

const activeColor = {
  color: COLORS[0],
  get colored() {
    if(this.color === WHITE) return 0;
    let number = 0;
    for(let i = 0; i < gridCells.length; i++)
      if(gridCells[i].style.backgroundColor === this.color)
        number++;
    return number;
  }
};

colors.forEach((color, index) => {
  color.style.backgroundColor = COLORS[index];
  color.addEventListener('click', e => {
    const prevSelected = document.querySelector('.selected');
    if(prevSelected) prevSelected.classList.remove('selected');
    e.target.classList.add('selected');
    activeColor.color = e.target.style.backgroundColor;
  })
})

gridCells.forEach(cell => {
  cell.addEventListener("click", e => {
    if(activeColor.colored >= 4) return;
    const selectedCell = e.target;  
    console.log(selectedCell.style.backgroundColor)
    if(selectedCell.style.backgroundColor != "") return;
    if(canBeColored(parseInt(selectedCell.dataset.row), parseInt(selectedCell.dataset.column)))
      selectedCell.style.backgroundColor = activeColor.color;
  })
})

function canBeColored(row, column){
  if(activeColor.colored === 0) return true;

  const directions = 4;
  const dirRow = [1, -1, 0, 0];
  const dirColumn = [0, 0, 1, -1];
  
  for(let i = 0; i < directions; i++){
    let newRow = row + dirRow[i];
    let newColumn = column + dirColumn[i];
    let neighbourCell = Array.from(gridCells) 
        .find(cell => cell.dataset.row == newRow && cell.dataset.column == newColumn)
    if(neighbourCell && neighbourCell.style.backgroundColor == activeColor.color) return true;
  }
  
  return false;
}

restartButton.addEventListener('click', () => location.reload());

document.getElementById('startClick').click();