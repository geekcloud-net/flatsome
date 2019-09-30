/* global flatsome_gutenberg, wp */
(function () {
  'use strict'

  var FlatsomeGutenberg = {
    headerToolbar: null,
    editButton: null,
    init: function () {
      if (!flatsome_gutenberg.edit_button.enabled) {
        return
      }

      this.buttonText = flatsome_gutenberg.edit_button.text
      this.editUrl = flatsome_gutenberg.edit_button.url
      this.buttonIcon = '<svg style="width:16px; height:16px;" width="16" height="16" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M15.9433 4.47626L18.474 7.00169L7.01624 18.4357L4.48556 15.9103L15.9433 4.47626ZM15.9433 0L0 15.9103L7.01624 22.912L22.9596 7.00169L15.9433 0Z" fill="white"/> <path d="M16.128 22.83L18.4798 25.1769L16.128 27.5239L13.7761 25.1769L16.128 22.83ZM16.128 18.3537L9.29039 25.1766L16.128 32L22.9655 25.1766L16.128 18.3532V18.3537Z" fill="white"/> <path d="M25.229 13.7475L27.5808 16.0945L25.229 18.4414L22.8775 16.0946L25.2293 13.7477L25.229 13.7475ZM25.2293 9.27141L18.3914 16.0946L25.229 22.918L32.0666 16.0946L25.229 9.27124L25.2293 9.27141Z" fill="white" fill-opacity="0.6"/> </svg>'

      this.addEditButton()
      this.bindEvents()
    },
    addEditButton: function () {
      this.headerToolbar = document.querySelector('.block-editor .edit-post-header-toolbar')

      if (!this.headerToolbar) return
      this.headerToolbar.insertAdjacentHTML('beforeend',
        '<button id="uxbuilder-edit-button" class="components-button is-button is-primary is-large">' + this.buttonIcon + this.buttonText + '</button>')

      this.editButton = this.headerToolbar.querySelector('#uxbuilder-edit-button')
    },
    bindEvents: function () {
      var self = this

      if (!this.editButton) return
      this.editButton.addEventListener('click', function (e) {
        e.preventDefault()

        this.classList.add('is-busy')
        this.blur()

        var title = wp.data.select('core/editor').getEditedPostAttribute('title')
        if (!title) wp.data.dispatch('core/editor').editPost({title: 'Auto Draft'})

        wp.data.dispatch('core/editor').savePost()
        self.redirectToBuilder()
      }, false)
    },
    redirectToBuilder: function () {
      var self = this

      setTimeout(function () {
        if (wp.data.select('core/editor').isSavingPost()) {
          return self.redirectToBuilder()
        }
        if (wp.data.select('core/editor').didPostSaveRequestSucceed()) {
          location.href = self.editUrl
          self.editButton.innerHTML += '...'
        } else {
          self.editButton.classList.remove('is-busy')
        }
      }, 500)
    }

  }

  document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
      FlatsomeGutenberg.init()
    }, 10)
  })
}())
