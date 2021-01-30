const schoolClasses = ["1", "2", "3", "4","5", "6", "7", "8", "9", "10", "11", "12"]
const universityClasses = [
  "I. év alapképzés",
  "II. év alapképzés", 
  "III. év alapképzés", 
  "IV. év alapképzés", 
  "I. év mesteri", 
  "II. év mesteri"
];
let dropDownType = null; // Iskolás OR Egyetemista 

const registrationOptions = {
  "Iskolás": {
    "Csiky Gergely Főgimnázium, Arad": schoolClasses,
    "Aurel Vlaicu Általános Iskola, Arad": schoolClasses,
    "Szacsvay Imre Általános Iskola, Nagyvárad": schoolClasses,   
    "Szent László Római Katolikus Iskolaközpont, Nagyvárad": schoolClasses,   
    "Ady Endre Elméleti Líceum, Nagyvárad": schoolClasses    
  },

  "Egyetemista": {
    "Partiumi Kresztény Egyetem": {
      "Óvo- és Tanítóképző": universityClasses, 
      "Képzőművészet-Grafika": universityClasses, 
      "Kereskedelem, Turizmus, Szolgáltatás-gazdaságtan": universityClasses
    }
  }
}
const typeSelection = document.querySelector("[data-type]");
const institutionSelection = document.querySelector("[data-institution]");
const majorSelection = document.querySelector("[data-major]");
const classSelection = document.querySelector("[data-class]");
const submitButton = document.querySelector('[data-submit]')
const playerIdInput = document.querySelector('[data-playerid]')

for (let option in registrationOptions) {
  typeSelection.options[typeSelection.options.length] = new Option(option, option);
}


typeSelection.addEventListener('change', e => {
  institutionSelection.length = 1;
  majorSelection.length = 1;
  classSelection.length = 1;
  institutionSelection.classList.add('hidden');
  majorSelection.classList.add('hidden');
  classSelection.classList.add('hidden');

  selection = e.target.value;

  if(selection  == "") return;

  dropDownType = selection;

  for (let option in registrationOptions[selection]) {
    institutionSelection.options[institutionSelection.options.length] = new Option(option, option);
  }
  institutionSelection.classList.remove('hidden');
});


institutionSelection.addEventListener('change', e => {
  majorSelection.length = 1;
  classSelection.length = 1;

  selection = e.target.value;

  if(selection  === "") {
    majorSelection.classList.add('hidden');
    classSelection.classList.add('hidden');
    return;
  }

  if(dropDownType === "Iskolás") {
    for (let option of registrationOptions[typeSelection.value][selection]) {
      classSelection.options[classSelection.options.length] = new Option(option, option);
    }
    classSelection.classList.remove('hidden');
  } 
  else if(dropDownType === "Egyetemista") {
    for (let option in registrationOptions[typeSelection.value][selection]) {
      majorSelection.options[majorSelection.options.length] = new Option(option, option);
    }
    majorSelection.classList.remove('hidden');
  }

});

majorSelection.addEventListener('change', e => {
  classSelection.length = 1;
  classSelection.classList.add('hidden');
  
  selection = e.target.value;
  
  if(selection  === "") return;
  
  for (let option of registrationOptions[typeSelection.value][institutionSelection.value][selection]) {
    classSelection.options[classSelection.options.length] = new Option(option, option);
  }
  classSelection.classList.remove('hidden');
})

classSelection.addEventListener('change', e => {
  selection = e.target.value;
  
  if(selection  === "") {
    submitButton.disabled = true;
    playerIdInput.classList.add('hidden');
  }
  else {
    submitButton.disabled = false;
    playerIdInput.classList.remove('hidden');
  }
})
playerIdInput.addEventListener('change', e => {
  if(e.target.value !== "")
    submitButton.disabled = false;
})