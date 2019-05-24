import $ from 'jquery';

class MyNotes {

    constructor() {

        this.events();
    }

    events() {

        // look for element with id tag then update class elements within id tag after event trigger
        $("#my-notes").on("click", ".delete-note", this.deleteNote ); // jquery onclick event call deleteNote function
        $("#my-notes").on("click", ".edit-note", this.editNote.bind(this) ); // jquery onclick event call editNote function
        $("#my-notes").on("click", ".update-note", this.updateNote.bind(this) ); 

        // Update class element on event trigger 
        $(".submit-note").on("click", this.createNote.bind(this) ); 


    }

    editNote(event) {

        var thisNote = $(event.target).parents("li"); // jquery access data in the li tag via click event
        if(thisNote.data("state")=="editable") {

            //Make Readonly
            this.makeNoteReadonly(thisNote);

        } else {

            // Make Editable
            this.makeNoteEditable(thisNote);
        }
     
    }

    makeNoteEditable(thisNote) {

        thisNote.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"> Cancel </i>');
        thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
        thisNote.find(".update-note").addClass("update-note--visible");
        thisNote.data("state", "editable");
    }

    makeNoteReadonly(thisNote) {

        thisNote.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"> Edit </i>');
        thisNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");
        thisNote.find(".update-note").removeClass("update-note--visible");
        thisNote.data("state", "cancel");
    }

    deleteNote(event) {

        var thisNote = $(event.target).parents("li"); // jquery access data in the li tag via click event
        
        $.ajax({
//                  // Set Request Header with Authorization API Token
            beforeSend: (xhr) => { xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);},

            url: universityData.root_url + '/wp-json/wp/v2/note/'+ thisNote.data('id'), 
            type: 'DELETE', 
            success: (response)=>{
                        thisNote.slideUp();
                        console.log("Congrats");
                        console.log(response);

                        if(response.userNoteCount < 5) {

                            $(".note-limit-message").removeClass("active");
                        }
                        
                        }, 
            error: (response)=>{
                console.log("Sorry Error here");
                console.log(response);
                },
        });
    }

    updateNote(event) {

        var thisNote = $(event.target).parents("li"); // jquery access data in the li tag via click event
        
        var ourUpdatePost = {
                                'title': thisNote.find(".note-title-field").val(),
                                'content': thisNote.find(".note-body-field").val()
                            }

        $.ajax({
//                  // Set Request Header with Authorization API Token
            beforeSend: (xhr) => { xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);},

            url: universityData.root_url + '/wp-json/wp/v2/note/'+ thisNote.data('id'), 
            type: 'POST', 
            data: ourUpdatePost,
            success: (response)=>{
                        this.makeNoteReadonly(thisNote);
                        console.log("Congrats");
                        console.log(response);
                        }, 
            error: (response)=>{
                console.log("Sorry Error here");
                console.log(response);
                },
        });
    }

    createNote(event) {

        var ourNewPost = {
                                'title': $(".new-note-title").val(),
                                'content': $(".new-note-body").val(),
                                'status': 'publish',
                                
                            }

        $.ajax({
//                  // Set Request Header with Authorization API Token
            beforeSend: (xhr) => { xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);},

            url: universityData.root_url + '/wp-json/wp/v2/note/', 
            type: 'POST', 
            data: ourNewPost,
            success: (response)=>{

                        $(".new-note-title, .new-note-body").val(''); // jquery set fields to an empty string
                        // Add li tag to an element with id=my-notes
                        $(`

             <li data-id="${response.id}"> 
                <input readonly class="note-title-field" value="${response.title.raw}">
                <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"> Edit </i></span>
                <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"> Delete </i></span>
                <textarea readonly class="note-body-field">${response.content.raw} </textarea>
                <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"> Save </i></span>
             </li>     
                        `).prependTo("#my-notes").hide().slideDown(); 
                        console.log("Congrats");
                        console.log(response);
                        }, 
            error: (response)=>{
                if(response.responseText == "You have reach your note limit.") {

                    $(".note-limit-message").addClass("active");
                }

                console.log("Sorry Error here");
                console.log(response);
                },
        });
    }
}

export default MyNotes;