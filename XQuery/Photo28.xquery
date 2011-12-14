declare namespace tns = "http://www.example.org/final";
declare option ddtek:serialize "method=CSV:first=yes";

<table>
	{
	for $uploads in /tns:photodb/tns:user/tns:uploads 
	return 
	<row>
		<userID>
			{
			$uploads/../*/tns:userId/text()
			}
		</userID>
		<photoID>
			{
			$uploads/tns:Photo/tns:photoId/text()
			}
		</photoID>
		<url>
			{
			$uploads/tns:Photo/tns:url/text()
			}
		</url>
		<Visibility>
			{
			if( exists($uploads/tns:access/tns:Everyone) ) then "public" else "restricted"
			}
		</Visibility>
	</row>
	}
</table>(: Stylus Studio meta-information - (c) 2004-2009. Progress Software Corporation. All rights reserved.

<metaInformation>
	<scenarios>
		<scenario default="yes" name="Scenario1" userelativepaths="yes" externalpreview="no" useresolver="yes" url="pennphoto-28.xml" outputurl="" processortype="datadirect" tcpport="0" profilemode="0" profiledepth="" profilelength="" urlprofilexml=""
		          commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" host="" port="0" user="" password="" validateoutput="no"
		          validator="internal" customvalidator="">
			<advancedProperties name="DocumentURIResolver" value=""/>
			<advancedProperties name="CollectionURIResolver" value=""/>
			<advancedProperties name="ModuleURIResolver" value=""/>
		</scenario>
	</scenarios>
	<MapperMetaTag>
		<MapperInfo srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="converter:CSV:first=yes?Photo.csv" destSchemaRoot="table" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no">
			<SourceSchema srcSchemaPath="pennphoto-28.xml" srcSchemaRoot="tns:photodb" AssociatedInstance="" loaderFunction="document" loaderFunctionUsesURI="no"/>
		</MapperInfo>
		<MapperBlockPosition>
			<template name="xquery_body">
				<block path="table/flwr" x="181" y="59"/>
			</template>
		</MapperBlockPosition>
		<TemplateContext></TemplateContext>
		<MapperFilter side="source"></MapperFilter>
	</MapperMetaTag>
</metaInformation>
:)