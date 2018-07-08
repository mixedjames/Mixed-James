/*
  James'
  Copyright (C) 2018 James Heggie

  This library is free software; you can redistribute it and/or
  modify it under the terms of the GNU Lesser General Public
  License as published by the Free Software Foundation; either
  version 2.1 of the License, or (at your option) any later version.

  This library is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
  Lesser General Public License for more details.

  You should have received a copy of the GNU Lesser General Public
  License along with this library; if not, write to the Free Software
  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
*/

define([
  'jquery'
], function(
  $
){

  MathJax.Hub.Config({
    jax: ["input/TeX","output/HTML-CSS"],
    displayAlign: "center"
  });

  $('a').click(function(e) {
    //e.preventDefault();

    var qs = $(e.target).closest('a')[0].search;

    console.log(getUrlParameter(qs, 'cat'));
    console.log(getUrlParameter(qs, 'f'));
  });

  // From https://davidwalsh.name/query-string-javascript
  function getUrlParameter(queryString, name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(queryString);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
  };

  $('#fullscreen').click(function(){
    $(document.body).toggleClass('fullscreen');
  });
});