import { ComponentFixture, TestBed } from '@angular/core/testing';
import { CreateParrainageComponent } from './create.component';

describe('CreateParrainageComponent', () => {
  let component: CreateParrainageComponent;
  let fixture: ComponentFixture<CreateParrainageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CreateParrainageComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CreateParrainageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
