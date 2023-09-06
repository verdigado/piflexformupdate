# pi_flexform Update

## Updates data in pi_flexform

This extension is helpful, if you have to replace values in plugins en masse.

This extension is a collection of special purpose upgrade wizards.
It is ready to use in context with the EXT:xblog.
If you want it to use for other extensions, the existing scripts serve as a template. 

If you want to replace values in any pi_flexform field of any plugin,
copy the code and adapt it to your needs. See details at :ref:`Developers <developers>`


The extension can do this for you in context with the EXT:xblog:

* Upgrade wizard PiflexformupdateXblogArchive: Enable the property "Display only archived news" 
* Upgrade wizard PiflexformupdateXblogGrid: Updates the grid of xBlog plugin main 
  from 8|4 to 9|3 and 4|8 to 3|9, if image height is 165 pixel and width is 220 pixel.
* Upgrade wizard PiflexformupdateXblogImagesizemode:  Sets "Size in list view" to "See below [plugin]"
  and "Size in single view" to "From record [record]"

This extension is for developers only.
See details at the [Documentation](Documentation/Index.rst)