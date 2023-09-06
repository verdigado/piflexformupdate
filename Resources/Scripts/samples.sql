SELECT    COUNT(uid),
          ExtractValue(pi_flexform,'/T3FlexForms/data/sheet[@index="image"]/language/field[@index="settings.flexform.pi.image.imageSizemodeList"]/value') AS imageSizemodeList
FROM      tt_content
WHERE     deleted=0 
AND       hidden=0
AND       CType = 'list'
AND       list_type = 'xblog_pi1'
AND       ExtractValue(pi_flexform,'/T3FlexForms/data/sheet[@index="image"]/language/field[@index="settings.flexform.pi.image.imageSizemodeList"]/value') = ''
GROUP BY  imageSizemodeList;


SELECT    COUNT(uid),
          ExtractValue(pi_flexform,'/T3FlexForms/data/sheet[@index="image"]/language/field[@index="settings.flexform.pi.image.imageSizemodeSingle"]/value') AS imageSizemodeSingle
FROM      tt_content
WHERE     deleted=0 
AND       hidden=0
AND       CType = 'list'
AND       list_type = 'xblog_pi1'
AND       ExtractValue(pi_flexform,'/T3FlexForms/data/sheet[@index="image"]/language/field[@index="settings.flexform.pi.image.imageSizemodeSingle"]/value') = ''
GROUP BY  imageSizemodeSingle;

