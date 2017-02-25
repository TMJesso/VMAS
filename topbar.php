

Navigation
Top Bar
HTML

<div class="title-bar" data-responsive-toggle="main-menu" data-hide-for="medium">

  <button class="menu-icon" type="button" data-toggle></button>

  <div class="title-bar-title">Menu</div>

</div>



<div class="top-bar" id="main-menu">

  <div class="top-bar-left">

    <ul class="dropdown menu" data-dropdown-menu>

      <li class="menu-text">Site Title</li>

    </ul>

  </div>

  <div class="top-bar-right">

    <ul class="menu" data-responsive-menu="drilldown medium-dropdown">

      <li class="has-submenu">

        <a href="#">One</a>

        <ul class="submenu menu vertical" data-submenu>

          <li><a href="#">One</a></li>

          <li><a href="#">Two</a></li>

          <li><a href="#">Three</a></li>

        </ul>

      </li>

      <li><a href="#">Two</a></li>

      <li><a href="#">Three</a></li>

    </ul>

  </div>

</div>

CSS

body {
  margin-top: 2rem; }

.title-bar {
  background: #333;
  padding: 0.9rem; }

.top-bar {
  background: #333; }
  .top-bar ul {
    background: #333; }
    .top-bar ul li {
      background: #333; }
      .top-bar ul li a {
        color: #fff; }

.menu-text {
  color: #fff; }
  @media only screen and (max-width: 40em) {
    .menu-text {
      display: none !important; } }

@media only screen and (min-width: 40em) {
  .menu:last-child {
    border-left: 1px solid #4e4e4e; }

  .menu:first-child {
    border-left: none; }

  .menu li:not(:last-child) {
    border-right: 1px solid #4e4e4e; } }
.dropdown.menu .submenu {
  border: none; }

.dropdown.menu .is-dropdown-submenu-parent.is-right-arrow > a::after {
  border-color: #fff transparent transparent; }

.is-drilldown-submenu-parent > a::after {
  border-color: transparent transparent transparent #fff; }

.js-drilldown-back::before {
  border-color: transparent #fff transparent transparent; }

SCSS

// for presentation only

body {margin-top: 2rem;}



$menu-background: #333;



.title-bar {

  background: $menu-background;

  padding: 0.9rem;

}



.top-bar {

  background: $menu-background;

  

  ul {

    background: $menu-background;

  

    li {

      background: $menu-background;

    

        a {

          color: #fff;

      }

    }

  }

}



.menu-text {

  color: #fff;

  

  @media only screen and (max-width: 40em) {

    display: none !important;

  }

}



@media only screen and (min-width: 40em) {

  .menu:last-child {

    border-left: 1px solid #4e4e4e;

  }



  .menu:first-child {

    border-left: none;

  }



  .menu {

    li:not(:last-child) {

      border-right: 1px solid #4e4e4e;

    }

  }

}



.dropdown.menu .submenu {

  border: none;

}



.dropdown.menu .is-dropdown-submenu-parent.is-right-arrow>a::after {

  border-color: #fff transparent transparent;

}



.is-drilldown-submenu-parent>a::after {

  border-color: transparent transparent transparent #fff;

}



.js-drilldown-back::before {

  border-color: transparent #fff transparent transparent;

}


