import $ from 'jquery';

class Search {

    constructor() {

       this.addSearchHTML();
       this.resultsDiv = $("#search-overlay__results");
       this.openButton = $(".js-search-trigger");
       this.closeButton = $(".search-overlay__close");
       this.searchOverlay = $(".search-overlay");
       this.searchField = $("#search-term");
       this.events();
       this.isOverlayOpen = false;
       this.typingTimer;
       this.spinnerVisible = false;
       this.previousValue;
    }

    // Events
    events() {

        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this));
        $(document).on("keyup", this.keyPressDispatcher.bind(this));
        this.searchField.on("keyup", this.typingLogic.bind(this) ); // 'keydown' fires before the browser loads
    }

   

    typingLogic() {

        if (this.searchField.val() != this.previousValue) {

        clearTimeout (this.typingTimer); // cancel previous timeout

        if (this.searchField.val()) {
        
            if (!this.spinnerVisible) {

           this.resultsDiv.html('<div class="spinner-loader"></div>');
           this.spinnerVisible = true;} 

       this.typingTimer = setTimeout( this.getResults.bind(this), 1000);
            
        } else {

            this.resultsDiv.html('');
            this.spinnerVisible = false;
        }

      
    }
       this.previousValue = this.searchField.val();
    }

    getResults() {

        /* this.resultsDiv.html("Just of test of my search");
        this.spinnerVisible = false; */

        $.when(
        // get site name from function.php wp_localize_script
        $.getJSON(universityData.root_url+'/wp-json/wp/v2/posts?search='+ this.searchField.val() ),
        $.getJSON(universityData.root_url+'/wp-json/wp/v2/pages?search='+ this.searchField.val())
        ).then((posts, pages)=> {

            var combinedResults = posts[0].concat(pages[0]); // combine the two search results Api's
            
            this.resultsDiv.html(`
            <h2 class='search-overlay__section-title'>General Information</h2>
            
            ${combinedResults.length ? '<ul class="link-list min-list">': '<p>No General Information</p>'}
             ${combinedResults.map(item => `<li><a href="${item.link}"> ${item.title.rendered} </a></li>`).join()}          
            ${combinedResults.length ? '</ul>':''}
            `);
                 this.spinnerVisible = false;

        }, () => {this.resultsDiv.html('<p>Unexpected Error. please try again later </p>')});

    }



    keyPressDispatcher(event) {

       // console.log('Test school');

        if (event.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(':focus')) {

            this.openOverlay();
        }

        if (event.keyCode == 27 && this.isOverlayOpen) {

            this.closeOverlay();
        }
    }

    openOverlay() {
        
        this.searchOverlay.addClass("search-overlay--active");
        $("body").addClass("body-no-scroll");
        this.searchField.val('');
        setTimeout(()=> this.searchField.focus(), 302);
        this.isOverlayOpen = true;
    }

    closeOverlay() {

        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
        this.isOverlayOpen = false;
    }

    addSearchHTML () {

        $("body").append(`
        <div class="search-overlay"> 
          <div class="search-overlay__top">
              <div class="container"> 
                <i class="fa fa-search search-overlay__icon" aria-hidden="true">  </i>
                  <input  type="text" class="search-term" placeholder="Search here" id="search-term" />
                <i class="fa fa-window-close search-overlay__close" aria-hidden="true">  </i>
            </div>
        </div>
      
        <div class="container"> 
        <div id="search-overlay__results"> </div>
        </div>
      
      </div>`)
    }
}

export default Search;