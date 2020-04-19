
var Clipboard = new function () {
    var clipboard = this;

    var storage = JSON.parse(window.localStorage.explorer_clipboard || '{}');

    this.stack = storage.stack || [];
    this.method = storage.method || null;
    this.clear = function () {
        clipboard.stack = [];
        window.localStorage.setItem('explorer_clipboard', JSON.stringify({ stack: [], }));
    }
    this.copy = function (obj) {
        clipboard.method = "copy";
        clipboard.add(obj);
    }
    this.cut = function (obj) {
        clipboard.method = "move";
        clipboard.add(obj);
    }
    this.add = function (obj) {
        var stack = [];
        document.forms.directory.querySelectorAll("label > input:checked").forEach(function (inp) {
            stack.push(inp.value);
        });
        if (stack.length) {
            clipboard.stack = stack;
        } else {
            clipboard.stack = [obj.dataset.path];
        }
        window.localStorage.setItem('explorer_clipboard', JSON.stringify({
            stack: clipboard.stack,
            method: clipboard.method
        }));
    }
}

var get = function () {
    var answer = [];
    document.forms.directory.querySelectorAll("input.file:checked").forEach(function (inp) {
        answer.push({
            type: inp.dataset.type,
            path: inp.value,
            uri: inp.dataset.uri
        });
    });
    return answer;
}

var upload = function () {
    var inp = document.create("input", {
        type: "file",
        name: "image",
        accept: "*.*",
        multiple: "multiple"
    });
    inp.onchange = function () {
        new POPUP('/Explorer/log', function (popup) {
            var log = popup.body;
            var progress = popup.body.querySelector("progress");
            XHR.uploader(
                inp.files,
                "/Explorer" + location.search,
                function (index, size, seek, response) {
                    progress.max = size;
                    progress.value = seek;
                    log.current.value = inp.files[index].name;
                    if (seek >= size) {
                        if (index) {
                            log.insertToBegin(document.create("tt", { class: "block px-10px" }, response));
                        } else {
                            location.reload(true);
                        }
                    }
                }
            );
        });
    }
    inp.click();
}

var createDirectory = function (message) {
    parent.showPrompt(message, function (value) {
        XHR.json({
            method: "POST",
            body: {
                name: value
            },
            addressee: "/Explorer" + location.search,
            onsuccess: function (response) {
                if (response != "Success") {
                    parent.showAlert(response);
                }
                location.reload(true);
            }
        });
    }, "Directory Name");
}

var removeSelected = function (message, path) {
    parent.showConfirm(message, function () {
        XHR.json({
            method: "DELETE",
            body: (function (list) {
                if (path) {
                    list.push(path);
                } else {
                    document.forms.directory.querySelectorAll("input:checked").forEach(function (itm) {
                        list.push(itm.value);
                    });
                }
                return list;
            })([]),
            addressee: "/Explorer",
            onsuccess: function (response) {
                if (response != "Success") {
                    parent.showAlert(response);
                }
                location.reload();
            }
        });
    });
}

var paste = function (obj) {
    XHR.json({
        method: "PATCH",
        body: {
            target: CURRENT_PATH,
            sources: Clipboard.stack
        },
        addressee: "/Explorer/" + Clipboard.method,
        onsuccess: function (response) {
            if (response != "Success") {
                parent.showAlert(response);
            } else {
                Clipboard.clear();
            }
            location.reload();
        }
    });
}

var rename = function (obj) {
    parent.showPrompt("Rename", function (value) {
        XHR.json({
            method: "PATCH",
            body: {
                name: value,
                source: obj.dataset.path
            },
            addressee: "/Explorer/rename",
            onsuccess: function (response) {
                if (response != "Success") {
                    parent.showAlert(response);
                }
                location.reload();
            }
        });
    }, "...", obj.dataset.path.split("/").pop());
}

var zip = function (obj) {
    XHR.text({
        method: "PATCH",
        body: obj.dataset.path,
        addressee: "/Explorer/zip",
        onsuccess: function (response) {
            if (response != "Success") {
                parent.showAlert(response);
            }
            location.reload();
        }
    });
}
var unzip = function (obj) {
    XHR.text({
        method: "PATCH",
        body: obj.dataset.path,
        addressee: "/Explorer/unzip",
        onsuccess: function (response) {
            if (response != "Success") {
                parent.showAlert(response);
            }
            location.reload();
        }
    });
}
var download = function (path) {
    parent.location.href = "/Explorer/download?path=" + path;
}

function showContextMenu(obj, event) {
    CONTEXT_MENU = document.body.create('form', {
        class: "context-menu fixed light-bg shadow-bold",
        style: "top: " + (event.clientY - 20) + "px; left:" + (event.clientX - 20) + "px;"
    });

    if (obj.classList.contains('explorer')) {
        if (Clipboard.stack.length) {
            CONTEXT_MENU.appendChild(
                document.querySelector("#paste-item").cloneNode(true).content
            );
            CONTEXT_MENU.paste.onclick = paste;
        }
        CONTEXT_MENU.appendChild(
            document.querySelector("#root-context-menu").cloneNode(true).content
        );

        CONTEXT_MENU.upload.onclick = function (event) {
            event.preventDefault();
            upload();
        }
        CONTEXT_MENU.create.onclick = function (event) {
            event.preventDefault();
            createDirectory(this.textContent);
        }
        CONTEXT_MENU.select.onclick = function (event) {
            event.preventDefault();
            document.forms.directory.querySelectorAll("label > input").forEach(function (inp) {
                inp.checked = true;
            });
        }
    } else {
        if (obj.dataset.type == "directory") {
            CONTEXT_MENU.appendChild(
                document.querySelector("#zip-item").cloneNode(true).content
            );
            CONTEXT_MENU.zip.onclick = function (event) {
                event.preventDefault();
                zip(obj);
            }
        } else if (obj.dataset.type == "zip") {
            CONTEXT_MENU.appendChild(
                document.querySelector("#unzip-item").cloneNode(true).content
            );
            CONTEXT_MENU.unzip.onclick = function (event) {
                event.preventDefault();
                unzip(obj);
            }
        }
        CONTEXT_MENU.appendChild(
            document.querySelector("#context-menu").cloneNode(true).content
        );

        CONTEXT_MENU.copy.onclick = function (event) {
            event.preventDefault();
            Clipboard.copy(obj);
        }
        CONTEXT_MENU.cut.onclick = function (event) {
            event.preventDefault();
            Clipboard.cut(obj);
        }
        CONTEXT_MENU.rename.onclick = function (event) {
            event.preventDefault();
            rename(obj);
        }
        CONTEXT_MENU.delete.onclick = function (event) {
            event.preventDefault();
            removeSelected(
                this.textContent + ' "' + obj.textContent.trim() + '"',
                obj.dataset.path
            );
        }
    }
    CONTEXT_MENU.onsubmit = function (event) {
        event.preventDefault();
    }

    var rect = CONTEXT_MENU.getBoundingClientRect();
    if (rect.bottom > window.innerHeight) {
        var delta = window.innerHeight - CONTEXT_MENU.offsetHeight;
        CONTEXT_MENU.style.top = delta + "px";
    }
    if (rect.right > window.innerWidth) {
        var delta = window.innerWidth - CONTEXT_MENU.offsetWidth;
        CONTEXT_MENU.style.left = delta + "px";
    }

    document.onclick = function () {
        document.onclick = null;
        document.body.removeChild(CONTEXT_MENU);
    }
}