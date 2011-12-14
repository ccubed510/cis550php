declare namespace tns = "http://www.example.org/final";
declare option ddtek:serialize "method=CSV:first=yes";

<table>
	{
	for $professor in /tns:photodb/tns:user/tns:professor
	for $advisee in $professor/tns:advices
	return if (exists(/tns:photodb/tns:user/tns:student[tns:userId=$advisee/tns:studentId]))
	then
	<row>
		<userName>
			{
			$professor/tns:accountId/text()
			}
		</userName>
		<advisee>
			{
			/tns:photodb/tns:user/tns:student[tns:userId=$advisee/tns:studentId]/tns:accountId/text()
			}
		</advisee>
	</row>
	else ()
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
		<MapperInfo srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="converter:CSV:first=yes?Professor.csv" destSchemaRoot="table" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no">
			<SourceSchema srcSchemaPath="pennphoto-28.xml" srcSchemaRoot="tns:photodb" AssociatedInstance="" loaderFunction="document" loaderFunctionUsesURI="no"/>
		</MapperInfo>
		<MapperBlockPosition>
			<template name="xquery_body">
				<block path="table/flwr" x="188" y="28"/>
			</template>
		</MapperBlockPosition>
		<TemplateContext></TemplateContext>
		<MapperFilter side="source"></MapperFilter>
	</MapperMetaTag>
</metaInformation>
:)