document.addEventListener("DOMContentLoaded", () => {    
    const addMemberButton = document.getElementById('addMember');
    const nestedList = document.getElementById('elementList');
    const groupNameInput = document.getElementById('name');

    if (groupNameInput) {
        groupNameInput.addEventListener('input', (event) => {
            fullObjectJSON.question = event.target.value;
        });
    }

    if (editing) {
        const nestedRemoveButtons = document.getElementsByClassName('removeMember');
        for (let nestedRemoveButton of nestedRemoveButtons) {
            let nestedDiv = nestedRemoveButton.parentElement;
            let answerName = nestedDiv.querySelector('.answerName').innerText;
            let isCorrect = nestedDiv.querySelector('.material-icons').innerText == 'cancel' ? 0 : 1;
            assignButtons(nestedDiv, answerName, nestedRemoveButton, isCorrect);
        }
    }

    addMemberButton.addEventListener('click', () => {
        const answerInput = document.querySelector('#answer');
        const answerCheckbox = document.querySelector('#isCorrect');

        const answer = answerInput.value;
        const isCorrect = answerCheckbox.checked ? 1 : 0;

        if (isInList(answer)) {
            alert(inListElement);
            return;
        }

        if (isCorrect == 1 && hasCorrectAnswer()) {
            alert('Pytanie już ma poprawną odpowiedź');
            return;
        }

        createNestedElement(answer, isCorrect);

        const nestedDiv = document.createElement('div');
        nestedDiv.classList.add('member', 'flex', 'flex-row', 'gap-2', 'items-center', 'p-2', 'bg-gray-500', 'rounded', 'mb-1', 'text-white');
        if (isCorrect) { nestedDiv.classList.add('bg-green-600'); } else { nestedDiv.classList.add('bg-rose-600'); }

        const nestedInfo = document.createElement('span');
        nestedInfo.innerText = answer;
        nestedInfo.classList.add('answerName');

        const nestedCorrect = document.createElement('span');
        nestedCorrect.classList.add('material-icons');
        nestedCorrect.innerText = isCorrect ? 'check_circle' : 'cancel';

        const button = document.createElement('button');
        button.type = 'button';
        button.classList.add('removeMember', 'cursor-pointer', 'hover:bg-rose-500', 'rounded', 'p-1', 'material-icons');
        button.innerText = 'remove';
        assignButtons(nestedDiv, answer, button, isCorrect);

        nestedDiv.appendChild(nestedCorrect);
        nestedDiv.appendChild(nestedInfo);
        nestedDiv.appendChild(button);
        nestedList.appendChild(nestedDiv);

        answerInput.value = '';
        answerCheckbox.checked = false;
    });
});

function assignButtons(nestedDiv, answer, button, isCorrect = null) {
    button.addEventListener('click', () => {
        document.querySelector('#answer').value = answer;
        document.querySelector('#isCorrect').checked = (isCorrect == 1) ? true : false;

        nestedDiv.remove();
        removeNestedElement(answer);
    });
}

function isInList(answerName) {
    return fullObjectJSON.answers.some(m => m.answer === answerName);
}
function hasCorrectAnswer() {
    return fullObjectJSON.answers.some(m => m.is_correct === 1);
}

const form = document.getElementById('actionForm');
form.addEventListener('submit', async (event) => {
    event.preventDefault();

    if (!fullObjectJSON.answers.some(answer => answer.is_correct === 1)) {
        alert('Pytanie nie ma poprawnej odpowiedzi');
        return;
    }

    const method = (editing) ? 'PATCH' : 'POST';
    const url = (editing) ? routes.update : routes.store;

    response = await sendData(fullObjectJSON, url, method);
    messages = "";

    for (const [key, value] of Object.entries(response)) {
        if (key != 'success') {
            messages += value + '\n';
        }
    }

    alert(messages);
    if (response.success) {
        window.location.href = document.referrer || "http://localhost:8000/";
    }
});