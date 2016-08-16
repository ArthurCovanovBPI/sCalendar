function displayHeadSelection(d)
{
	var headButtons = document.getElementsByClassName("headButton");
	var headSelections = document.getElementsByClassName("headSelections");
	var i;
	var l = (headSelections.length < headButtons.length)? headSelections.length : headButtons.length ;
	for(i = 0; i < l; i++)
	{
		if(i == d)
		{
			headButtons[i].classList.add("toogled");
			headSelections[i].style.display = "table";
		}
		else
		{
			headButtons[i].classList.remove("toogled");
			headSelections[i].style.display = "none";
		}
	}
}
