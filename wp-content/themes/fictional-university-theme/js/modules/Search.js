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
//                         Custom API route  // get site name from function.php wp_localize_script
        $.getJSON(universityData.root_url+'/wp-json/university/v1/search?term='+ this.searchField.val(), (results)=> {

            this.resultsDiv.html(`
            <div class="row">
                <div class="one-third"> 
                    <h2 class='search-overlay__section-title'> General Information </h2>

                    ${results.generalInfo.length ? '<ul class="link-list min-list">': '<p>No General Information</p>'}
             ${results.generalInfo.map(item => `<li><a href="${item.permalink}"> ${item.title} </a> 
              ${item.postType == 'post'? `by ${item.authorName}`:''}</li>`).join('')}          
            ${results.generalInfo.length ? '</ul>':''}
                </div>
                <div class="one-third">
                    <h2 class='search-overlay__section-title'> Programs </h2>
                    ${results.programs.length ? '<ul class="link-list min-list">':
                     `<p>No Programs Found</p> <a href="${universityData.root_url}/programs"> View All Programs </a>`}
                    ${results.programs.map(item => `<li><a href="${item.permalink}"> ${item.title} </a> 
                     </li>`).join('')}          
                   ${results.programs.length ? '</ul>':''}

                    <h2 class='search-overlay__section-title'> Professors </h2>
                    ${results.professors.length ? '<ul class="professor-cards">':
                    `<p>No professors Found</p> `}
                   ${results.professors.map(item => `
                   
                   <li class="professor-card__list-item">
                     <a class="professor-card" href="${item.permalink}">
                     <img class="professor-card__image" src="${item.image}">
                     <span class="professor-card__name"> ${item.title} </span>
                    </a> </li>
                   `).join('')}          
                  ${results.professors.length ? '</ul>':''}

                </div>
                <div class="one-third">
                    <h2 class='search-overlay__section-title'> Campuses </h2>
                    ${results.campuses.length ? '<ul class="link-list min-list">':
                     `<p>No Campus with that name</p> <a href="${universityData.root_url}/campuses"> View All Campuses </a>`}
                    ${results.campuses.map(item => `<li><a href="${item.permalink}"> ${item.title} </a> 
                     </li>`).join('')}          
                   ${results.campuses.length ? '</ul>':''}

                    <h2 class='search-overlay__section-title'> Events </h2>

                    ${results.events.length ? '':
                    `<p>No Campus with that name</p> <a href="${universityData.root_url}/events"> View All Events </a>`}
                   ${results.events.map(item => `

                   <div class="event-summary">
                <a class="event-summary__date t-center" href="${item.permalink}">
                 <span class="event-summary__month">
                 ${item.month}
                 </span>
                 <span class="event-summary__day">${item.day}</span>  
                 </a>
                 <div class="event-summary__content">
                 <h5 class="event-summary__title headline headline--tiny">
                 <a href="${item.permalink}">${item.title}</a></h5>
                 <p>
                      ${item.description}
                 <a href="${item.permalink}" class="nu gray">Learn more</a></p>
          </div>
        </div>
                   `).join('')}          
                 

                </div>
            `);

            this.spinnerVisible = false;
        });

        // biology = 1896, english = 1897, math = 1895, 
       

        /* $.when( // async request to Api routes
        // get site name from function.php wp_localize_script
        $.getJSON(universityData.root_url+'/wp-json/wp/v2/posts?search='+ this.searchField.val() ),
        $.getJSON(universityData.root_url+'/wp-json/wp/v2/pages?search='+ this.searchField.val())
        ).then((posts, pages)=> {

            var combinedResults = posts[0].concat(pages[0]); // combine the two search results Api's
            
            this.resultsDiv.html(`
            <h2 class='search-overlay__section-title'>General Information</h2>
            
            ${combinedResults.length ? '<ul class="link-list min-list">': '<p>No General Information</p>'}
             ${combinedResults.map(item => `<li><a href="${item.link}"> ${item.title.rendered} </a> 
              ${item.type == 'post'? `by ${item.authorName}`:''}</li>`).join('')}          
            ${combinedResults.length ? '</ul>':''}
            `);
                 this.spinnerVisible = false;

        }, () => {this.resultsDiv.html('<p>Unexpected Error. please try again later </p>')}); */

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
        return false;
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