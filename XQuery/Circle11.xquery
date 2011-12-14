declare option ddtek:serialize "method=CSV:first=yes";
<table>
	{
	for $circle in /photodb/circle 
	return 
	<row>
		<userID>
			{
			$circle/ownerID/text()
			}
		</userID>
		<circleID>
			{
			concat($circle/ownerID/text(),$circle/circleID/text())
			}
		</circleID>
		<name>
			{
			if($circle/name='') then concat($circle/ownerID/text(),$circle/circleID/text()) else $circle/name/text()
			}
		</name>
	</row>
	}
</table>(: Stylus Studio meta-information - (c) 2004-2009. Progress Software Corporation. All rights reserved.

<metaInformation>
	<scenarios>
		<scenario default="yes" name="Scenario1" userelativepaths="yes" externalpreview="no" useresolver="yes" url="pennphoto-11.xml" outputurl="" processortype="datadirect" tcpport="0" profilemode="0" profiledepth="" profilelength="" urlprofilexml=""
		          commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" host="" port="0" user="" password="" validateoutput="no"
		          validator="internal" customvalidator="">
			<advancedProperties name="DocumentURIResolver" value=""/>
			<advancedProperties name="CollectionURIResolver" value=""/>
			<advancedProperties name="ModuleURIResolver" value=""/>
		</scenario>
	</scenarios>
	<MapperMetaTag>
		<MapperInfo srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="converter:CSV:first=yes?Circle.csv" destSchemaRoot="table" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no">
			<SourceSchema srcSchemaPath="pennphoto-11.xml" srcSchemaRoot="photodb" AssociatedInstance="" loaderFunction="document" loaderFunctionUsesURI="no"/>
		</MapperInfo>
		<MapperBlockPosition>
			<template name="xquery_body">
				<block path="table/flwr" x="152" y="44"/>
			</template>
		</MapperBlockPosition>
		<TemplateContext></TemplateContext>
		<MapperFilter side="source"></MapperFilter>
	</MapperMetaTag>
</metaInformation>
:)