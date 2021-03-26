import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateDonComponent } from './create.component';

describe('CreateDonComponent', () => {
  let component: CreateDonComponent;
  let fixture: ComponentFixture<CreateDonComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CreateDonComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CreateDonComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
