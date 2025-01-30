interface TitleProps {
  title: string;
}

export const Title = ({ title }: TitleProps) => (
  <div className="mb-5 sm:flex sm:items-center">
    <div className="sm:flex-auto">
      <h1 className="text-2xl font-semibold text-gray-900">{title}</h1>
    </div>
  </div>
);
