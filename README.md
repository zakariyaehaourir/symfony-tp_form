# Symfony Project – Form Customization (AddToCart)

## Overview
The goal is to transform a standard HTML form into a **Symfony Form** and customize its rendering using a **Twig theme**.  
We use **Bootstrap 5** for styling and created a **reusable theme** for the form fields.

![Form](public/images_md/form.png)
---

## Steps Completed

### 1. Creating the FormType

1. Created the form using `php bin/console make:form AddToCartType`.
2. Added the required fields for the **Add to Cart** form:

```php
$builder
    ->add('quantity', IntegerType::class, [
        'label' => 'Quantity',
        'help' => 'Choose a number between 1 and 10',
        'attr' => ['min' => 1, 'max' => 10],
    ])
    ->add('color', ChoiceType::class, [
        'label' => 'Select Color',
        'choices' => [
            'Matte Black' => 'black',
            'Pearl White' => 'white',
            'Silver' => 'silver',
        ],
    ]);
```
### 2. Creation of Controller and Passing Form to the View
1. `php bin/console make:controller CartController`
2. In the action method, instantiated the form and passed it to the view.

` return $this->render('cart/index.html.twig' , ['form'=>$this->createForm(AddToCartType::class)]);`
### 3. Creation of Custom Twig Theme
1. Custom theme located at: `templates/form/themes/custom_add_to_cart.html.twig`
2. Customized the following blocks:
* integer_widget :for all formTypes (IntegerType)
* choice_widget :for all formTypes (ChoiceType)
* form_label:for labels added a unique structure
* form_info:for helpers of inputs
* form_errors:for structring errors displayed trigred with constraints
3. Example snippet from the theme

`{% block integer_widget %}
    <input type="number" {{ block('widget_attributes') }} class="form-control" style="max-width: 100px;" />
{% endblock %}`

widget_attributes represente all attributs declared in each formtype to ensure coherence like id,name ...

### 4. Using Constraints for Server-Side Validation
1. Added Symfony constraints in the FormType
```php
'constraints' => [
        new Assert\NotBlank([
                        'message' => 'Fill the quantity field.',
                    ]),
        new Assert\GreaterThanOrEqual([
            'value' => 1,
            'message' => 'Quantity cannot be less than  : {{ compared_value }}.',
                ]),
        new Assert\LessThanOrEqual([
                'value' => 10,
                'message' => 'Quantity cannot be greater than :{{ compared_value }}.',
            ]),
        ]
```
After removing the attributs min & max with inspect to remove html constraints

![Errors](public/images_md/errors.png)

### 5. Applying the Theme in the Main View
1. In `templates/cart/index.html.twig`

Applies the custom theme
{% form_theme form with ['form/themes/custom_add_to_cart.html.twig'] %}

```php
{% block body %}
    {{ form_start(form) }}
        {{ form_row(form.quantity) }}
        {{ form_row(form.color) }}
        <button type="submit" class="btn btn-primary btn-lg">Add to Cart</button>
    {{ form_end(form) }}
{% endblock %}
```
* form_row :will render each field with label,widget,info if exist,errors also <b>:)</b>
