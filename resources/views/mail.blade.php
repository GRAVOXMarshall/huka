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
    <h1>hola</h1>
  <!-- <?php 


    $domDocument = new DOMDocument('1.0', "UTF-8");
    $domElement = $domDocument->createElement('h1');
    //$domElement->createTextNode("hola amigo");
    $domAttribute = $domDocument->createAttribute('class');

    // Value for the created attribute
    $domAttribute->value = 'attributevalue';

    // Don't forget to append it to the element
    $domElement->appendChild($domAttribute);

    // Append it to the document itself
    $domDocument->appendChild($domElement);

    echo $domDocument->saveHTML();

    ?> -->
   <?php $domDocument = new DOMDocument('1.0', "UTF-8"); ?>
    @foreach($components as $component)
      
      @if($component->tagName != "")
      <?php $domElement = $domDocument->createElement($component->tagName); ?>
        @if(count($component->classes) > 0)
        <?php $domAttribute = $domDocument->createAttribute('class'); ?> 
          @foreach($component->classes as $compClasses)
          <?php $domAttribute->value .= $compClasses->name." "; ?>
          <?php $domElement->appendChild($domAttribute); ?>
          @endforeach
          <?php $domDocument->appendChild($domElement); ?>
        @endif

        @if(gettype($component->attributes) == "object")
          <?php $values = array_values(array($component->attributes)); ?>
          <?php $keys = array_keys(array($component->attributes)); ?>
        @endif

      @endif

    <?php echo $domDocument->saveHTML(); ?> 
    @endforeach
     <script type="text/javascript">
      const components =  @json($components);
    components.forEach(function(component) {   
     element = builderElement(component);  
      document.body.appendChild(element);   
    }); 
    function builderElement(data) {
        var element;
        if (data.tagName != "") {
          element = document.createElement(data.tagName);
          if (data.classes.length > 0) {
            data.classes.forEach(function(classElement) {
              element.classList.add(classElement.name);
            });
          }

          if (typeof data.attributes == "object") {
            var values = Object.values(data.attributes);
            var keys = Object.keys(data.attributes);
            for (var i = 0; i < values.length; i++) {
              element.setAttribute(keys[i], values[i]);
            }
          }

          if (data.src != "undefined" && data.type == "image") {
            element.setAttribute("src", data.src);
          }

          if (data.content != "") {
            var content = document.createTextNode(data.content);
            element.appendChild(content);
          }
        
          if (data.components.length > 0) {
            data.components.forEach(function(childComponent) {
              element.appendChild(builderElement(childComponent));
            });
          }

        }else if(data.type == "textnode"){
          element = document.createTextNode(data.content);
        }
        return element;
      }
    </script>  
  </body>
</html>