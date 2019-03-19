import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

@Component({
	templateUrl: "datetime-picker.component.html"
})

export class DatetimePickerComponent implements OnInit {

	dateTimePickerForm: FormGroup = null;

	constructor(private formBuilder: FormBuilder) {

	}

	ngOnInit(): void {
		this.dateTimePickerForm = this.formBuilder.group({
			date: ["", [Validators.required]],
			time: ["", [Validators.required]]
		})
	}

	submit() {
		let date = this.dateTimePickerForm.value.date;
		let time = this.dateTimePickerForm.value.time;
		let startTime = new Date(date.year, date.month, date.day, time.hour, time.minute);
		let endTime = new Date(date.year, date.month, date.day, time.hour, time.minute);
		console.log(startTime.getTime());
		console.log(endTime.getTime());
	}
}