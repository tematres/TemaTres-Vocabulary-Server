<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match='/'>
  <html>
        <xsl:apply-templates />
  </html>
</xsl:template>
                   <xsl:param name="tipoTermino"/>
<xsl:template match='Zthes'>
     <head><title>TemaTres:Zthes</title></head>
     <body>
        <a name="arriba"></a>
        <xsl:for-each select='term' >
        <a name="t{termId}"></a>
                <fieldset>

                <legend><h2> <xsl:value-of select='termName' />  </h2></legend>
                <u>Tipo de término: <xsl:value-of select='termType' />  </u>
                <p><xsl:value-of select='termNote' />  </p>
                <ul>
            <xsl:for-each select='relation' >
              <xsl:choose>
                <xsl:when test="relationType='BT'">
                     <li style="list-style: none;"><xsl:value-of select='relationType' />: <a href="#t{termId}"><xsl:value-of select='termName' /></a></li>
                </xsl:when>

                <xsl:when test="relationType='UF'">
                     <li type="circle"><xsl:value-of select='relationType' />: <xsl:value-of select='termName' /></li>
                </xsl:when>

                <xsl:when test="relationType='NT'">
                      <li style="margin-left: 2mm;" ><xsl:value-of select='relationType' />: <a href="#t{termId}"><xsl:value-of select='termName' /></a></li>
                </xsl:when>

                <xsl:when test="relationType='RT'">
                      <li style="margin-left: 4mm;" type="square"><xsl:value-of select='relationType' />: <a href="#t{termId}"><xsl:value-of select='termName' /></a></li>
                </xsl:when>
              </xsl:choose>
           </xsl:for-each>
             </ul>
                [<a href="#arriba">top</a>]
        </fieldset>
        <br/>
        </xsl:for-each>
  </body>
</xsl:template>
</xsl:stylesheet>