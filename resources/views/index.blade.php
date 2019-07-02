<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page->name }}</title> 
    <style>
    {{ $css }}
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset($template) }}">
    <script src="{{ asset('js/app.js') }}"></script>
  </head>
  <body>
    @if($errors->all() != [])
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    @endif
    <script type="text/javascript">
      const token = axios.defaults.headers.common['X-CSRF-TOKEN'];
      const components = @json($components);
      components.forEach(function(component) {
        element = builderElement(component);
        document.body.appendChild(element);
      });

      /**
      * This function creates the elements of the pages,
      * And children of a element.
      * @param JSON data
      * @return String element
      */
      function builderElement(data) {
        var element;
        if (data.tagName != '') {
          element = document.createElement(data.tagName);
          console.log(data);
          if (data.classes.length > 0) {
            data.classes.forEach(function(classElement) {
              element.classList.add(classElement.name);
            });
          }

          if (typeof data.attributes == 'object') {
            var values = Object.values(data.attributes);
            var keys = Object.keys(data.attributes);
            for (var i = 0; i < values.length; i++) {
              element.setAttribute(keys[i], values[i]);
            }
          }

          if (data.src != 'undefined' && data.type == 'image') {
            element.setAttribute('src', data.src);
          }

          if (data.content != '') {
            var content = document.createTextNode(data.content);
            element.appendChild(content);
          }

          if (data.tagName == 'form') {
            var inputToken = document.createElement('input');
            inputToken.setAttribute('type', 'hidden');
            inputToken.setAttribute('name', '_token');
            inputToken.setAttribute('value', token);
            element.appendChild(inputToken);
          }
        
          if (data.components.length > 0) {
            data.components.forEach(function(childComponent) {
              element.appendChild(builderElement(childComponent));
            });
          }

        }else if(data.type == 'textnode'){
          element = document.createTextNode(data.content);
        }
        return element;
      }
    </script>
  </body>
</html>