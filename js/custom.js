  var $ajaxload_popup = $('.ajaxload-popup');
            if( $ajaxload_popup.length > 0 ) {
                $ajaxload_popup.magnificPopup({
                  type: 'ajax',
                  alignTop: true,
                  overflowY: 'scroll', // as we know that popup content is tall we set scroll overflow by default to avoid jump
                  callbacks: {
                    parseAjax: function(mfpResponse) {
                      THEMEMASCOT.initialize.TM_datePicker();
                      THEMEMASCOT.initialize.TM_sliderRange();
                      THEMEMASCOT.initialize.TM_ddslick();
                    }
                  }
                });
            }