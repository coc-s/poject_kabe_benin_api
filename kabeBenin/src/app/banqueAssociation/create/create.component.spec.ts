import { ComponentFixture, TestBed } from '@angular/core/testing';
import { CreateBanqueAssociationComponent } from './create.component';

describe('CreateComponent', () => {
  let component: CreateBanqueAssociationComponent;
  let fixture: ComponentFixture<CreateBanqueAssociationComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CreateBanqueAssociationComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CreateBanqueAssociationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});