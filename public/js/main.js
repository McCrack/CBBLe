
var PopUpPool = {};
var POPUP = function (path, method) {
    let box = this;
    XHR.push({
        method: method || "GET",
        addressee: path,
        onsuccess: function (response) {
            var mount = document.fragment(response);
            box.mount = mount.firstElementChild;
            box.window = box.mount.querySelector(".pop-up");
            //box.body = box.window.querySelector(".pop-up-body");

            box.mount.querySelectorAll("script").forEach(function (sct) {
                var script = document.createElement("script");
                if (sct.src) {
                    script.src = sct.src;
                } else script.innerHTML = sct.innerHTML;
                sct.parentNode.replaceChild(script, sct);
            });

            for (var handle in PopUpPool) {
                PopUpPool[handle].mount.style.zIndex = 99;
            }
            PopUpPool[box.mount.id] = box;

            document.body.appendChild(mount);
        }
    });
    box.drop = function () {
        document.body.removeChild(box.mount);
        delete (PopUpPool[box.handle]);
    }
}

/* Table rows ******************************************************/

function addRow(row) {
    var newRow = row.cloneNode(true);
    newRow.querySelectorAll("td").forEach(function (cell) {
        cell.innerHTML = "";
        cell.setAttribute('contenteditable', "true");
    });
    row.insertAdjacentElement("afterEnd", newRow);
}
function deleteRow(row, onDelete) {
    row.parentNode.removeChild(row);
    if (onDelete) onDelete();
}

/* Prepare data ************************************************/

function taginate(event, minlength, maxlength, pattern) {
    clearTimeout(TIMEOUT);
    TIMEOUT = setTimeout(function () {
        var words = [];
        var field = event.target;
        var str = field.value.trim();
        minlength = minlength || 1;
        if (str.length >= minlength) {
            field.value = "";
            str.split(pattern || /,*\s+/g).forEach(function (tag) {
                if ((tag.length >= minlength) && (tag.length <= (maxlength || tag.length))) {
                    field.parentNode.insertBefore(
                        document.create('span', { class: "tag" }, tag),
                        field
                    );
                } else {
                    words.push(tag);
                }
            });
            field.value = words.join(" ");
            field.selectionStart = field.value.length;
        }
    }, 2000);
}

/* Alerts ******************************************************/

function showAlert(message) {
    var template = document.querySelector("#alert").cloneNode(true);
    var mount = template.content.firstElementChild;
    mount.message.value = message;
    document.body.appendChild(mount);
    mount.onreset = function (event) {
        event.preventDefault();
        mount.parentNode.removeChild(mount);
    }
    mount.onsubmit = function (event) {
        event.preventDefault();
    }
}
function showConfirm(message, callback) {
    var template = document.querySelector("#confirm").cloneNode(true);
    var form = template.content.firstElementChild;
    form.message.value = message;
    document.body.appendChild(form);
    form.onreset = function (event) {
        event.preventDefault();
        form.parentNode.removeChild(form);
    }
    form.onsubmit = function (event) {
        event.preventDefault();
        form.parentNode.removeChild(form);
        callback();
    }
}
function showPrompt(message, callback, placeholder) {
    var template = document.querySelector("#prompt").cloneNode(true);
    var form = template.content.firstElementChild;
    form.message.value = message;
    document.body.appendChild(form);
    form.field.placeholder = placeholder || "...";
    form.field.focus();
    form.onreset = function (event) {
        event.preventDefault();
        form.parentNode.removeChild(form);
    }
    form.onsubmit = function (event) {
        event.preventDefault();
        callback(form.field.value);
        form.parentNode.removeChild(form);
    }
}

/* Dictionaries ************************************************/

function addDictionary(item) {
    var container = item.nextElementSibling;
    var field = document.create(
        'input',
        {
            class: "field ml-5 white-bg-1 white-txt blend-difference",
            placeholder: "Dictionary Name",
            style: "border-color: var(--success)"
        }
    );
    field.onblur = function () {
        if (/^[a-zA-Z0-9_-]{3,}$/g.test(field.value)) {
            XHR.json({
                method: "POST",
                addressee: "/Dictionaries",
                body: {
                    name: field.value,
                    subdomain: item.dataset.subdomain
                },
                onsuccess: function (response) {
                    response = JSON.parse(response);
                    if (response.status == "Success") {
                        container.replaceChild(
                            document.create(
                                'label', {
                                class: "block capitalize cursor-pointer success-txt hover-primary-txt",
                                onclick: "new POPUP('/Dictionaries/" + field.value + "/" + item.dataset.subdomain + "')"
                            }, "一 " + field.value),
                            field
                        );
                        new POPUP("/Dictionaries/" + field.value + "/" + item.dataset.subdomain);
                    } else {
                        showAlert(response.message);
                    }
                }
            });
        } else {
            showAlert("Invalid dictionary name");
            container.removeChild(field);
        }
    }
    field.onkeypress = function (event) {
        if (event.keyCode == 13) {
            field.blur();
        }
    }
    container.appendChild(field);
    field.focus();
}