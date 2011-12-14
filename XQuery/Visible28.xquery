declare namespace tns = "http://www.example.org/final";
declare option ddtek:serialize "method=CSV:first=yes";

<table>
	{
	for $uploads in /tns:photodb/tns:user/tns:uploads 
	return
	if(exists($uploads/tns:access/tns:listofF)) then
	for $friends in $uploads/tns:access/tns:listofF/tns:userId
	return
	<row>
		<photoID>
			{
			$uploads/tns:Photo/tns:photoId/text()
			}
		</photoID>
		<viewerID>
			{
			$friends/text()
			}
		</viewerID>
	</row>
	else
	for $circles in $uploads/tns:access/tns:listofCir/tns:circleId
	for $user in /tns:photodb/tns:user/tns:circles where $user/tns:circleId=$circles
	return
	for $friend in $user/tns:friends/tns:userId
	return
	<row>
		<photoID>
			{
			$uploads/tns:Photo/tns:photoId/text()
			}
		</photoID>
		<viewerID>
			{
			$friend/text()
			}
		</viewerID>
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
		<MapperInfo srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="converter:CSV:first=yes?Visible.csv" destSchemaRoot="table" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no">
			<SourceSchema srcSchemaPath="pennphoto-28.xml" srcSchemaRoot="tns:photodb" AssociatedInstance="" loaderFunction="document" loaderFunctionUsesURI="no"/>
		</MapperInfo>
		<MapperBlockPosition>
			<template name="xquery_body">
				<block path="table/if" x="315" y="6"/>
				<block path="table/if/exists[0]" x="269" y="0"/>
				<block path="table/if//flwr" x="265" y="36"/>
				<block path="table/if/[1]/flwr" x="265" y="90"/>
			</template>
		</MapperBlockPosition>
		<TemplateContext></TemplateContext>
		<MapperFilter side="source"></MapperFilter>
	</MapperMetaTag>
</metaInformation>
:)