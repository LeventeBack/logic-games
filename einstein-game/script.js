const timer = {
  startTime: new Date(), 
  endTime: null,
  get time(){
    return (this.endTime.getTime() - this.startTime.getTime()) / 1000;
  }
}
let completed = 0;

const fileNames = ["animal", "drink", "hobby", "nationality"];

const targetCells = document.querySelectorAll('[data-target-cell]');
const images = document.querySelectorAll('[data-img]');
const categoryContainers = document.querySelectorAll('.category-container');
const houseContainer = document.querySelector('[data-house-container]');

const restartBtn = document.querySelector('[data-restart]');
const finishBtn = document.querySelector('[data-finish]');

const messageDiv = document.querySelector('[data-message]');
const messageScore = document.querySelector('[data-message-score]');
const messageText = document.querySelector('[data-message-text]');

restartBtn.addEventListener('click', () => location.reload());
finishBtn.addEventListener('click', () => {
  if(confirm("Biztosan be szeretnéf fejzeni a játékot? Ha igen, már nem léphetsz vissza újra!")) {
    const points = countScore();
    const scoreText = `${points}/100 pontot értél el` ;
    let text;
    if(points < 20)      text = "Sajnálom, ez most nem sikerült jól!";
    else if(points < 40) text = "Ne szomorkodj, máskor jobb lesz!";
    else if(points < 60) text = "Nem rossz, csak így tovább!";
    else if(points < 75) text = "Ügyes vagy!";
    else if(points < 90) text = "Nagyon jól dolgoztál!";
    else if(points < 99) text = "Profin dolgoztál!";
    else                 text = "Tökéletes megoldás! Gratulálok!";
    
    messageScore.innerText = scoreText;
    messageText.innerText = text;
    messageDiv.classList.remove('hidden');

    timer.endTime = new Date();
    saveData(points);
  }
})

images.forEach(image => {
  image.setAttribute('draggable', true);
  image.addEventListener('dragstart', e => e.target.classList.add('dragging'));
  image.addEventListener('dragend', e => e.target.classList.remove('dragging'));
})

categoryContainers.forEach(container => {
  const childImages = container.querySelectorAll('[data-img]');
  childImages.forEach(img => {
    img.style.order = Math.round(Math.random() * 100);
  })
})

targetCells.forEach(cell => {
  cell.addEventListener('dragover', e => {
    e.preventDefault();
    const selection = e.target;

    if (!selection.classList.contains('house__cell')) return;
    if (selection.innerHTML != "") return;

    const draggedImg = document.querySelector('.dragging');
    selection.appendChild(draggedImg);
    draggedImg.classList.add('inserted');
    draggedImg.addEventListener('click', teleportBack, { once: true });
  })
})

function teleportBack(e) {
  const imageType = e.target.dataset.type;
  const container = Array.from(categoryContainers).find(c => c.dataset.container == imageType);
  container.appendChild(e.target);
  e.target.classList.remove('inserted');
}

function setupImages() {
  let index = 0;
  fileNames.forEach(fileName => {
    for (let nr = 1; nr <= 5; nr++) {
      images[index].style.background = `url(images/${fileName}${nr}.jpg)`;
      images[index].style.backgroundSize = 'contain';
      images[index].dataset.type = fileName;
      index++;
    }
  });
}

function countScore() {
  let score = 0;
  const houses = document.querySelectorAll('.house');
  houses.forEach((house, index) => {
    const childImages = house.querySelectorAll('[data-img]');
    childImages.forEach(childImg => {
      score += childImg.dataset.id == house.dataset.order; 
    }) 
    score += house.dataset.order == index + 1;
  })
  return score * 4;
}

$(() => {
  $("#house-container").sortable({
    tolerance: "pointer"
  }); 
});

function saveData(points){
  completed = 1;
  html2canvas(houseContainer).then(canvas => {
    const image = canvas.toDataURL("image/jpg", 0.9);
    $.ajax({
      type: "POST",
      url: './save.php',
      data: {
        image: image, 
        time: timer.time,
        completed,
        score: points
      },
      success: (result) => {
        console.log(result);
      }
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

setupImages();