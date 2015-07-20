# PDFThumb Craft plugin

Generate previews of PDF files.

## Pre-requirements

PHP ImageMagick library must be installed.

## How to use

Twig example*:

    <div class="pdf">
        {% set params = { width: 640 } %}
        <img src="{{ pdfthumb.get(block.file.first().url, params) }}">
        <div class="centered"><div>
            <a href="{{ block.file.first().url }}"><i class="fa fa-expand"></i> PDF</a>
        </div></div>
    </div>

where `block.file.first().url` is a URL of PDF file, and `params` can have `width` or `height` properties or both.

![Screenshot](Readme.png)

\* CSS not included

## To-Do

* Support for multi-site setups.
* Support for remote Assets URLs.

I am looking for a maintainer for this project. 

## License
Copyright © 2015 [Mikhail Emelchenkov](https://mikhail.guru). Source code is distributed under [CDDL 1.0](https://tldrlegal.com/license/common-development-and-distribution-license-(cddl-1.0)-explained) open source license.