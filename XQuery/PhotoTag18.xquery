declare namespace tns = "http://www.example.org/pennphoto";
declare option ddtek:serialize "method=CSV:first=yes";

<table>
	{
	for $photo in /tns:photodb/*/tns:photo where exists($photo/tns:tagging)
	return 
	<row>
		<photoID>
			{
			concat($photo/../tns:id/text(),$photo/tns:photoID/text())
			}
		</photoID>
		<tag>
			{
			$photo/tns:tagging/tns:tag/text()
			}
		</tag>
		<tagger>
			{
			$photo/tns:tagging/tns:tagger/text()
			}
		</tagger>
	</row>
	}
</table>(: Stylus Studio meta-information - (c) 2004-2009. Progress Software Corporation. All rights reserved.

<metaInformation>
	<scenarios>
		<scenario default="yes" name="Scenario1" userelativepaths="yes" externalpreview="no" useresolver="yes" url="pennphoto-18.xml" outputurl="" processortype="datadirect" tcpport="0" profilemode="0" profiledepth="" profilelength="" urlprofilexml=""
		          commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" host="" port="0" user="" password="" validateoutput="no"
		          validator="internal" customvalidator="">
			<advancedProperties name="DocumentURIResolver" value=""/>
			<advancedProperties name="CollectionURIResolver" value=""/>
			<advancedProperties name="ModuleURIResolver" value=""/>
		</scenario>
	</scenarios>
	<MapperMetaTag>
		<MapperInfo srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="converter:CSV:first=yes?PhotoTag.csv" destSchemaRoot="table" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no">
			<SourceSchema srcSchemaPath="pennphoto-18.xml" srcSchemaRoot="tns:photodb" AssociatedInstance="" loaderFunction="document" loaderFunctionUsesURI="no"/>
		</MapperInfo>
		<MapperBlockPosition>
			<template name="xquery_body">
				<block path="table/flwr" x="107" y="52"/>
			</template>
		</MapperBlockPosition>
		<TemplateContext></TemplateContext>
		<MapperFilter side="source"></MapperFilter>
	</MapperMetaTag>
</metaInformation>
:)