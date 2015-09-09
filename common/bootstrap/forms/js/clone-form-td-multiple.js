/*
Author: Tristan Denyer (based on Charlie Griefer's original clone code, and some great help from Dan - see his comments in blog post)
Plugin repo: https://github.com/tristandenyer/Clone-section-of-form-using-jQuery
Demo at http://tristandenyer.com/using-jquery-to-duplicate-a-section-of-a-form-maintaining-accessibility/
Ver: 0.9.4.3
Last updated: Mar 22, 2015

The MIT License (MIT)

Copyright (c) 2011 Tristan Denyer

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
$(function () {
    $('#btnAdd_1').click(function () {
        var num     = $('.clonedInput_1').length, // Checks to see how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
            newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
    
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
        Below are examples of what forms elements you can clone, but not the only ones.
        There are 2 basic structures below: one for an H2, and one for form elements.
        To make more, you can copy the one for form elements and simply update the classes for its label and input.
        Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    */
        // Label for email field
        newElem.find('.label_email').attr('id', 'ID' + newNum + '_reference').attr('name', 'ID' + newNum + '_reference').html('Email #' + newNum);

        // Email input - text
        newElem.find('.label_email').attr('for', 'ID' + newNum + '_email_address');
        newElem.find('.input_email').attr('id', 'ID' + newNum + '_email_address').attr('name', 'ID' + newNum + '_email_address').val('');

    // Insert the new element after the last "duplicatable" input field
        $('#entry' + num).after(newElem);
        $('#ID' + newNum + '_title').focus();

    // Enable the "remove" button. This only shows once you have a duplicated section.
        $('#btnDel_1').attr('disabled', false);

    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
        // This first if statement is for forms using input type="button" (see older demo). Delete if using button element.
        if (newNum == 5)
        $('#btnAdd_1').attr('disabled', true).prop('value', "You've reached the limit"); // value here updates the text in the 'add' button when the limit is reached
        // This second if statement is for forms using the new button tag (see Bootstrap demo). Delete if using input type="button" element.
        if (newNum == 5)
        $('#btnAdd_1').attr('disabled', true).text("You've reached the limit"); // value here updates the text in the 'add' button when the limit is reached 
    });

    $('#btnDel_1').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
        if (confirm("Are you sure you wish to remove this email? This cannot be undone."))
            {
                var num = $('.clonedInput_1').length;
                // how many "duplicatable" input fields we currently have
                $('#entry' + num).slideUp('slow', function () {$(this).remove();
                // if only one element remains, disable the "remove" button
                    if (num -1 === 1)
                $('#btnDel_1').attr('disabled', true);
                // enable the "add" button. IMPORTANT: only for forms using input type="button" (see older demo). DELETE if using button element.
                $('#btnAdd_1').attr('disabled', false).prop('value', "Add email");
                // enable the "add" button. IMPORTANT: only for forms using the new button tag (see Bootstrap demo). DELETE if using input type="button" element.
                $('#btnAdd_1').attr('disabled', false).text("Add email");});
            }
        return false; // Removes the last section you added
    });
    // Enable the "add" button
    $('#btnAdd_1').attr('disabled', false);
    // Disable the "remove" button
    $('#btnDel_1').attr('disabled', true);





    $('#btnAdd_2').click(function () {
        var num     = $('.clonedInput_2').length, // Checks to see how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
            newElem = $('#phone' + num).clone().attr('id', 'phone' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
    
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
        Below are examples of what forms elements you can clone, but not the only ones.
        There are 2 basic structures below: one for an H2, and one for form elements.
        To make more, you can copy the one for form elements and simply update the classes for its label and input.
        Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    */
        // H2 - section
        newElem.find('.label_phone').attr('id', 'ID' + newNum + '_reference').attr('name', 'ID' + newNum + '_reference').html('Phone #' + newNum);

        // Phone - text
        newElem.find('.label_phone').attr('for', 'ID' + newNum + '_phone_number');
        newElem.find('.input_phone').attr('id', 'ID' + newNum + '_phone_number').attr('name', 'ID' + newNum + '_phone_number').val('');

    // Insert the new element after the last "duplicatable" input field
        $('#phone' + num).after(newElem);
        $('#ID' + newNum + '_title').focus();

    // Enable the "remove" button. This only shows once you have a duplicated section.
        $('#btnDel_2').attr('disabled', false);

    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
        // This first if statement is for forms using input type="button" (see older demo). DELETE if using button element.
        if (newNum == 5)
        $('#btnAdd_2').attr('disabled', true).prop('value', "You've reached the limit"); // value here updates the text in the 'add' button when the limit is reached
        // This second if statement is for forms using the new button tag (see Bootstrap demo). DELETE if using input type="button" element.
        if (newNum == 5)
        $('#btnAdd_2').attr('disabled', true).text("You've reached the limit"); // value here updates the text in the 'add' button when the limit is reached 
    });

    $('#btnDel_2').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
        if (confirm("Are you sure you wish to remove this phone number? This cannot be undone."))
            {
                var num = $('.clonedInput_2').length;
                // how many "duplicatable" input fields we currently have
                $('#phone' + num).slideUp('slow', function () {$(this).remove();
                // if only one element remains, disable the "remove" button
                    if (num -1 === 1)
                $('#btnDel_2').attr('disabled', true);
                // enable the "add" button. IMPORTANT: only for forms using input type="button" (see older demo). DELETE if using button element.
                $('#btnAdd_2').attr('disabled', false).prop('value', "Add phone");
                // enable the "add" button. IMPORTANT: only for forms using the new button tag (see Bootstrap demo). DELETE if using input type="button" element.
                $('#btnAdd_2').attr('disabled', false).text("Add phone");});
            }
        return false; // Removes the last section you added
    });
    // Enable the "add" button
    $('#btnAdd_2').attr('disabled', false);
    // Disable the "remove" button
    $('#btnDel_2').attr('disabled', true);
});