declare namespace tns = "http://www.example.org/final";
declare option ddtek:serialize "method=CSV:first=yes";

<table>
	{
	for $user in /tns:photodb/tns:user/tns:student | /tns:photodb/tns:user/tns:professor 
	return 
	<row>
		<userID>
			{
			$user/tns:userId/text()
			}
		</userID>
		<first_name>
			{
			$user/tns:firstName/text()
			}
		</first_name>
		<last_name>
			{
			$user/tns:lastName/text()
			}
		</last_name>
		<email>
			{
			$user/tns:email/text()
			}
		</email>
		<birth_date>
			{
			$user/tns:birthdate/text()
			}
		</birth_date>
		<gender>
			{
			$user/tns:gender/text()
			}
		</gender>
		<address>
			{
			concat($user/../tns:address/tns:aptNo/text()," ",$user/../tns:address/tns:street/text(),", ",$user/../tns:address/tns:city/text(),", ",$user/../tns:address/tns:state/text()," ",$user/../tns:address/tns:zipCode/text()," ",$user/../tns:address/tns:country/text()) 
			}
		</address>
		<password>
			{
			$user/tns:password/text()
			}
		</password>
		<userName>
			{
			$user/tns:accountId/text()
			}
		</userName>
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
		<MapperInfo srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="converter:CSV:first=yes?User.csv" destSchemaRoot="table" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no">
			<SourceSchema srcSchemaPath="pennphoto-28.xml" srcSchemaRoot="tns:photodb" AssociatedInstance="" loaderFunction="document" loaderFunctionUsesURI="no"/>
		</MapperInfo>
		<MapperBlockPosition>
			<template name="xquery_body">
				<block path="table/flwr" x="124" y="19"/>
			</template>
		</MapperBlockPosition>
		<TemplateContext></TemplateContext>
		<MapperFilter side="source"></MapperFilter>
	</MapperMetaTag>
</metaInformation>
:)