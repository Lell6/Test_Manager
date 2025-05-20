document.addEventListener("DOMContentLoaded", () => {    
    const addMemberButton = document.getElementById('addMember');
    const nestedList = document.getElementById('elementList');
    const groupNameInput = document.getElementById('name');

    console.log(fullObjectJSON);

    if (groupNameInput) {
        groupNameInput.addEventListener('input', (event) => {
            fullObjectJSON.name = event.target.value;
        });
    }

    if (editing) {
        const nestedRemoveButtons = document.getElementsByClassName('removeMember');
        for (let nestedRemoveButton of nestedRemoveButtons) {
            let nestedDiv = nestedRemoveButton.parentElement;
            let nestedId = Number(nestedDiv.getAttribute(searchAttirubte));
            assignButtons(nestedDiv, nestedId, nestedRemoveButton);
        }
    }

    addMemberButton.addEventListener('click', () => {
        const userOption = document.getElementById('elementOption');
        const selectedStudentId = userOption.getAttribute('data-element-id');
        const userName = userOption.innerText;

        if (isInList(selectedStudentId)) {
            alert(inListElement);
            return;
        }

        createNestedElement(selectedStudentId);

        const nestedDiv = document.createElement('div');
        nestedDiv.classList.add('member', 'flex', 'flex-row', 'gap-2', 'items-center', 'p-2', 'bg-gray-500', 'rounded', 'mb-1', 'text-white');
        nestedDiv.setAttribute(searchAttirubte, selectedStudentId);

        const nestedInfo = document.createElement('span');
        nestedInfo.innerText = userName;

        const button = document.createElement('button');
        button.type = 'button';
        button.classList.add('removeMember', 'cursor-pointer', 'hover:bg-rose-500', 'rounded', 'p-1', 'material-icons');
        button.innerText = 'remove';
        assignButtons(nestedDiv, selectedStudentId, button);

        nestedDiv.appendChild(nestedInfo);
        nestedDiv.appendChild(button);
        nestedList.appendChild(nestedDiv);
    });
});

function assignButtons(nestedDiv, nestedId, button) {
    button.addEventListener('click', () => {
        nestedDiv.remove();
        removeNestedElement(nestedId);
    });
}

function isInList(id) {
    return document.querySelector('['+ searchAttirubte +'="'+ id +'"]') !== null;
}


function updateIsIndividual(checkbox) {
    fullObjectJSON.is_individual = checkbox.checked ? 1 : 0;
    console.log(fullObjectJSON);
}

const form = document.getElementById('actionForm');
form.addEventListener('submit', async (event) => {
    event.preventDefault();
    console.log(fullObjectJSON);

    var method = (editing) ? 'PATCH' : 'POST';
    var url = (editing) ? routes.update : routes.store;

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