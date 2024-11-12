function btnEditCountyOnClick(id,name)
{
    const countyName = document.getElementById("county_name");
    countyName.value = name;

    const idCounty = document.getElementById("id_county");
    idCounty.value = id;
}