import Maker from './Maker.js';

class CommentForm {
    constructor() {
        this.commentForm = document.querySelector('#form-comment');
        this.textArea = document.querySelector('#comment_form_message');
        this.commentList = document.querySelector('#comment-list');
        this.init();
    }
    init () {
        this.scrollToLastComment();
        this.commentForm.addEventListener('submit', this.onSubmit);
    }

    onSubmit = (e) => {
        e.preventDefault();
        if ('true' === this.commentForm.dataset.listener) {
            return;
        }
        this.commentForm.dataset.listener = 'true';
        fetch(this.commentForm.action, {
            method: 'POST',
            body: new FormData(this.commentForm),
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((response) => {
                if (200 === response.status) {
                    return response.json();
                } else if (400 === response.status) {
                    return response.json()
                }
            })
            .then((data) => {
                if (data.error) {
                    Maker.flash(data.flash.message, data.flash.type);
                    return;
                }
                this.resetTextArea()
                this.insertComment(data);
                Maker.flash(data.flash.message, data.flash.type);
                this.scrollToLastComment();
            })
    }
    resetTextArea() {
        this.textArea.value = '';
        this.commentForm.dataset.listener = 'false';
    }

    insertComment(data) {
        if (data.day !== this.commentList.lastElementChild.dataset.day) {
            this.commentList.append(Maker.element('div', data.day, ['comment__date-separator']));
        }
        const div = document.createElement('div');
        div.innerHTML = data.message;
        this.commentList.append(div.firstElementChild);
        this.commentList.append(div.lastElementChild);
    }

    scrollToLastComment() {
        this.commentList.scrollTop = this.commentList.lastElementChild.offsetTop;

    }
}

new CommentForm();
