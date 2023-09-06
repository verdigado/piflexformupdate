SELECT    COUNT(uid),
          ExtractValue(pi_flexform,'/T3FlexForms/data/sheet[@index="image"]/language/field[@index="settings.flexform.pi.image.imageSizemodeList"]/value') AS imageSizemodeList
FROM      tt_content
WHERE     CType = 'list'
AND       deleted=0
-- AND       hidden=0
AND       list_type = 'xblog_pi1'
AND       (
                ExtractValue(pi_flexform,'/T3FlexForms/data/sheet[@index="image"]/language/field[@index="settings.flexform.pi.image.imageSizemodeList"]/value') IS NULL
            OR  ExtractValue(pi_flexform,'/T3FlexForms/data/sheet[@index="image"]/language/field[@index="settings.flexform.pi.image.imageSizemodeList"]/value') = ""
            OR  ExtractValue(pi_flexform,'/T3FlexForms/data/sheet[@index="image"]/language/field[@index="settings.flexform.pi.image.imageSizemodeSingle"]/value') IS NULL
            OR  ExtractValue(pi_flexform,'/T3FlexForms/data/sheet[@index="image"]/language/field[@index="settings.flexform.pi.image.imageSizemodeSingle"]/value') = ""
          )
GROUP BY  imageSizemodeList;
